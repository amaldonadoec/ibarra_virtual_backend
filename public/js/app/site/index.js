var modal = null;
var form = null;
var dataTable = null;
var translateStatus = {
    true: {title: "Activo", class: "m-badge--primary"},
    false: {title: "Inactivo", class: " m-badge--metal"},
};
var map = null;
var current_id = null;
var marker = null;
var autocomplete;
var images = [];
var audios = [];
var multimediaDeleted = [];


$(function () {
    modal = $('#modal');
    dataTable = initDatableAjax($('#entity_table'), {
        ajax: {
            url: $('#action_load').val(),
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
                field: "status",
                title: "Estado",
                template: function (t) {
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
                    return '<a href="javascript:;" onclick="handlerEdit(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
                }
            }
        ]
    });
    $("#entity_table_search").on("keyup", function () {
        var e = dataTable.getDataSourceQuery();
        e.term = $(this).val().toLowerCase();
        dataTable.setDataSourceQuery(e);
        dataTable.load();
    }).val("")
});

function handlerEdit(id) {
    modal.find('.modal-title').html('Editar');
    current_id = id;
    getForm($('#action_get_form').val() + '/' + id);
}

function handlerNew() {
    modal.find('.modal-title').html('Crear');
    current_id = null;
    getForm($('#action_get_form').val());
}

function save() {
    if (form.valid()) {
        var data = new FormData();
        var postData = form.serializeArray();
        for (var i = 0; i < postData.length; i++) {
            data.append(postData[i].name, postData[i].value);
        }
        $.each(images, function (index, file) {
            data.append('images[' + index + ']', file);
        });
        $.each(audios, function (index, file) {
            data.append('audios[' + index + ']', file);
        });
        $.each(multimediaDeleted, function (index, idImage) {
            data.append('multimediaDeleted[' + index + ']', idImage);
        });
        ajaxRequest($('#action_save').val(), {
            type: 'POST',
            data: data,
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar',
            success_message: 'Se guardó correctamente',
            success_callback: function (data) {
                modal.modal('hide');
                dataTable.reload();
                images = [];
                multimediaDeleted = [];
            }
        }, true);
    }
}

function getForm(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal.find('.container_modal').html('');
            modal.find('.container_modal').html(data.html);
            form = $("#entity_form");
            validateForm();
            modal.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
            setTimeout(function () {
                initMap();
                initAutocomplete();
                initDropZone();
                initDropZoneAudio();
                images = [];
                multimediaDeleted = [];
            }, 1000);
            $('#categories').select2({
                width: '100%',
                placeholder: 'Seleccione'
            });
            $(document).on("keypress", "form", function (event) {
                return event.keyCode != 13;
            });
        }
    });
}


function initMap() {
    var lat = parseFloat("0.34664955");
    var lng = parseFloat("-78.13275777");
    var zoom = 16;
    if (current_id != null) {
        lat = parseFloat($('#latitude').val());
        lng = parseFloat($('#longitude').val());
        zoom = 18;
    } else {
        $('#latitude').val(lat);
        $('#longitude').val(lng);
    }
    var default_position = {lat: lat, lng: lng};

    map = new GMaps({
        div: '#map',
        zoom: zoom,
        center: default_position,
        zoomControl: true,
        scaleControl: false,
        scrollwheel: false,
        disableDoubleClickZoom: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        bounds_changed: function () {
            marker.setPosition(map.getCenter());
            var lt = marker.getPosition().lat();
            var lg = marker.getPosition().lng();
            $('#latitude').val(lt.toFixed(8));
            $('#longitude').val(lg.toFixed(8));
        },
    });

    marker = map.createMarker({
        position: default_position,
    });

    map.addMarker(marker);
}

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete((document.getElementById('main_street')),
        {types: ['address'], componentRestrictions: {country: "EC"}});//validar region
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    map.setCenter({lat: lat, lng: lng});
}

function geolocate() {
    $('.pac-container').css('z-index', '1500');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
                position.coords.latitude, position.coords.longitude);
            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
                geolocation));
        });
    }
}

function validateForm() {
    form.validate({
        rules: {
            name: {
                required: true,
                maxlength: 45,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#entity_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        },
                    },
                }
            },
            'categories[]': {
                required: true
            },
            'description': {
                required: true
            }
        },
        messages: {
            name: {
                remote: 'El nombre ya esta en uso.'
            },
        },
        errorElement: 'span',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            save()
        }
    });
}


function initDropZone() {
    Dropzone.autoDiscover = false;
    var config = $("div#mydropzone").data();
    images = [];
    $("div#mydropzone").dropzone({
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
        init: function () {
            var myDropzone = this;
            myDropzone.on("addedfile", function (file) {
                /**Control for duplicate file*/
                if (this.files.length) {
                    var _i, _len;
                    for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
                    {
                        if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
                            this.removeFile(file);
                        }
                    }
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

function initDropZoneAudio() {
    Dropzone.autoDiscover = false;
    var config = $('div#wrapper_audio').data();
    audios = [];
    $("div#wrapper_audio").dropzone({
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
        previewTemplate: document
            .querySelector('#preview_file')
            .innerHTML,
        maxFiles: 1,
        init: function () {
            var myDropzone = this;
            myDropzone.on("addedfile", function (file) {
                while (this.files.length > this.options.maxFiles) {
                    this.removeFile(this.files[0]);
                }
                audios = this.files;
            });
            myDropzone.on("error", function (file) {
                this.removeFile(file);
                showAlert('error', 'Ocurrio un error al guardar la imagen');
            });

            myDropzone.on("removedfile", function (file) {
                audios = this.files;
            });
            /* control for accepted Files Type*/
            myDropzone.accept = function (file, done) {
                /*control for accepted types of images and dimentions*/
                if (!Dropzone.isValidFile(file, this.options.acceptedFiles)) {
                    showAlert('warning', 'Solo se permiten imágenes en formato: *' + this.options.acceptedFiles);
                    return this.removeFile(file);
                }
                if ($('.audio_exists').length > 0) {
                    showAlert('warning', 'Solo permite subir un audio');
                    this.removeFile(file);
                    return done(false);
                }
            }
        }
    });
}
