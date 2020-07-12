var modal_category = null;
var form_category = null;
var dataTable = null;
var translateStatus = {
    true: {title: "Activo", class: "m-badge--primary"},
    false: {title: "Inactivo", class: " m-badge--metal"},
};

var images = [];
var multimediaDeleted = [];
$(function () {
    modal_category = $('#modal');
    dataTable = initDatableAjax($('#category_table'), {
        ajax: {
            url: $('#action_load_categories').val(),
            method: 'GET'
        },
        pageSize: 10,
        columns: [
            {
                field: "name",
                title: "Nombre",
                sortable: 'asc',
                filterable: false,
                width: 150
            },
            {
                field: "description",
                title: "Descripción",
                sortable: 'asc',
                filterable: false,
                width: 150
            },
            {
                field: "status",
                title: "Estado",
                template: function (t) {
                    console.log(t);
                    return '<span class="m-badge ' + translateStatus[t.status].class + ' m-badge--wide">' + translateStatus[t.status].title + "</span>"
                }
            },
            {
                field: "",
                width: 110,
                title: "Acciones",
                sortable: false,
                overflow: "visible",
                template: function (t) {
                    return '<a href="javascript:;" onclick="editCategory(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
                }
            }
        ]
    })
});

function editCategory(id) {
    modal_category.find('.modal-title').html('Editar categoría');
    getFormCategory($('#action_get_form').val() + '/' + id);
}

function newCategory() {
    modal_category.find('.modal-title').html('Crear categoría');
    getFormCategory($('#action_get_form').val());
}

function saveCategory() {
    if (form_category.valid()) {
        var data = new FormData();
        var postData = form_category.serializeArray();
        for (var i = 0; i < postData.length; i++) {
            data.append(postData[i].name, postData[i].value);
        }
        $.each(images, function (index, file) {
            data.append('images[' + index + ']', file);
        });
        $.each(multimediaDeleted, function (index, idImage) {
            data.append('multimediaDeleted[' + index + ']', idImage);
        });

        ajaxRequest($('#action_save_category').val(), {
            type: 'POST',
            data: data,
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar la categoría',
            success_message: 'La categoría se guardo correctamente',
            success_callback: function (data) {
                modal_category.modal('hide');
                dataTable.reload();
                images = [];
                multimediaDeleted = [];
            }
        }, true);
    }
}

function getFormCategory(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_category.find('.container_modal').html('');
            modal_category.find('.container_modal').html(data.html);
            form_category = $("#category_form");
            validateFormCategory();
            initDropZone();
            modal_category.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateFormCategory() {
    form_category.validate({
        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#category_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    },
                }
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una categoría con ese nombre.'
            }
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            // form_category.submit
            saveCategory()
        }
    });
}

function initDropZone() {
    Dropzone.autoDiscover = false;
    var elementDropZone = $("div#mydropzone");
    var config = elementDropZone.data();
    images = [];
    elementDropZone.dropzone({
        url: $('#action_get_form').val(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        uploadMultiple: true,
        autoProcessQueue: true,
        // autoProcessQueue: false,
        // resizeWidth: config.maxWidth,
        // resizeHeight: config.maxHeight,
        dictInvalidFileType: 'No se puede cargar imagenes de este tipo',
        dictRemoveFile: 'Eliminar',
        addRemoveLinks: true,
        acceptedFiles: config.accepteFiles,
        maxFiles: 1,
        init: function () {
            var myDropzone = this;
            myDropzone.on("addedfile", function (file) {
                /**Control for duplicate file*/
                while (this.files.length > this.options.maxFiles) {
                    this.removeFile(this.files[0]);
                }
                images = this.files;
            });
            myDropzone.on("error", function (file) {
                this.removeFile(file);
                showAlert('error', 'Ocurrio un error al guardar la imagen');
            });

            myDropzone.on("removedfile", function (file) {
                images = this.files;
            });
            /* control for accepted Files Type*/
            myDropzone.accept = function (file, done) {
                if ($('.dz-image-preview').length > 0) {
                    showAlert('warning', 'Solo permite subir una imagen');
                    this.removeFile(file);
                    return done(false);
                }
                /*control for accepted types of images and dimentions*/
                if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
                    showAlert('warning', 'Solo se permiten imágenes en formato: *' + this.options.acceptedFiles);
                    return this.removeFile(file);
                }
            }
        }
    });
}

function deleteMultimedia(el, id) {
    multimediaDeleted.push(id);
    $(el).closest('.dz-preview').remove();
}
