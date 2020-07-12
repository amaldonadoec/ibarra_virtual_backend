var modal_user = null;
var form_user = null;
var dataTable = null;
$(function () {
    dataTable = initDatableAjax($('#user_table'),
        {
            ajax: {
                url: $('#action_list').val(),
                method: 'GET'
            },

            columns: [
                {
                    field: "name",
                    title: 'Nombre'
                },
                {
                    field: "email",
                    title: 'Email'
                },
                {
                    field: "status",
                    title: 'Estado',
                    template: function ( row) {
                        if (row.status) {
                            return '<span class="label label-sm label-success">Activo</span>';
                        } else {
                            return '<span class="label label-sm label-warning">Inactivo</span>';
                        }
                    }
                },
                {
                    field: null,
                    title: 'Acciones',
                    orderable: false,
                    template: function (row) {
                        if (row.id === 1)
                            return "";
                        return '<button class="btn btn-dark btn-sm" onclick="editUser(' + row.id + ')">Editar</button>';
                    }
                }
            ]
        });
    modal_user = $('#modal');
});

function editUser(id) {
    modal_user.find('.modal-title').html('Editar Usuario');
    getForm($('#action_get_form').val() + '/' + id);
}

function newUser() {
    modal_user.find('.modal-title').html('Crear Usuario');
    getForm($('#action_get_form').val());
}

function saveUser() {
    if (form_user.valid()) {
        ajaxRequest($('#action_save').val(), {
            type: 'POST',
            data: form_user.serialize(),
            blockElement: '#modal .modal-content',//opcional: es para bloquear el elemento
            loading_message: 'Guardando...',
            error_message: 'Error al guardar el usuario',
            success_message: 'El usuario se guardo correctamente',
            success_callback: function (data) {
                modal_user.modal('hide');
                dataTable.reload();
            }
        });
    }
}

function getForm(action) {
    ajaxRequest(action, {
        type: 'GET',
        error_message: 'Error al cargar formulario',
        success_callback: function (data) {
            modal_user.find('.container_modal').html('');
            modal_user.find('.container_modal').html(data.html);
            form_user = $("#user_form");
            validateForm();
            $('#role').select2({
                dropdownParent: $("#modal"),
                width: '100%',
                placeholder: '-Seleccione-'
            });
            modal_user.modal({
                show: true,
                backdrop: 'static',
                keyboard: false // to prevent closing with Esc button (if you want this too)
            });
        }
    });
}

function validateForm() {
    form_user.validate({

        rules: {
            name: {
                required: true,
                maxlength: 64,
                remote: {
                    url: $('#action_unique_name').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#user_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#name").val().trim();
                        }
                    }
                }
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: $('#action_unique_email').val(),
                    type: 'POST',
                    data: {
                        id: function () {
                            return $('#user_id').val();
                        },
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: function () {
                            return $("#email").val().trim();
                        }
                    }
                }
            },
            password: {
                required: true
            },
            'role[]': {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                remote: 'Ya existe una usuario con ese nombre.'
            },
            email: {
                remote: 'Ya existe una usuario con ese email.'
            }
        },
        errorElement: 'small',
        errorClass: 'form-control-feedback',
        highlight: validationHighlight,
        success: validationSuccess,
        errorPlacement: validationErrorPlacement,
        submitHandler: function (form) {
            saveUser();
        }
    });
}