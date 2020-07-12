function blockPage(label) {
    mApp.blockPage({
        overlayColor: '#000000',
        type: 'loader',
        state: 'success',
        message: label
    });
}

function blockContainer(el, label) {
    mApp.block(el, {
        overlayColor: '#000000',
        type: 'loader',
        state: 'success',
        message: label
    });
}

function unblockPage() {
    mApp.unblockPage();
}

function unblockContainer(el) {
    mApp.unblock(el);
}

function ajaxRequest(url, params, hasFileUpload) {
    var type = params.hasOwnProperty("type") ? params.type : 'GET';
    var blockElement = params.hasOwnProperty("blockElement") ? params.blockElement : null;
    var data = params.hasOwnProperty("data") ? params.data : [];
    var error_message = params.hasOwnProperty("error_message") ? params.error_message : 'Ha ocurrido un error durante la petición, inténtelo nuevamente.';
    var loading_message = params.hasOwnProperty("loading_message") ? params.loading_message : 'Cargando...';
    var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
    var processData = true;
    if (typeof hasFileUpload !== 'undefined' && hasFileUpload) {
        contentType = false;
        processData = false;
    }
    blockElement ? blockContainer(blockElement, loading_message) : blockPage(loading_message);
    $.ajax({
        type: type,
        url: url,
        dataType: 'json',
        data: data,
        contentType: contentType,
        processData: processData,
        beforeSend: function (jqXHR, settings) {
            if (params.hasOwnProperty("beforeSend")) {
                params.beforeSend(jqXHR, settings);
            }
        },
        error: function (data) {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            //Error messages from server
            if (data.responseJSON.hasOwnProperty('status') && data.responseJSON.hasOwnProperty('message')) {
                showAlert(data.responseJSON.status, data.responseJSON.message);
            } else { //Error messages from frontend
                showAlert('error', error_message);
            }
            if (params.hasOwnProperty("error_callback")) {
                params.error_callback(data);
            }
        },
        success: function (data) {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            //Error messages from server
            if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                showAlert(data.status, data.message);
            } else { //Error messages from frontend
                if (!data.hasOwnProperty("success") || data.success) {
                    if (params.hasOwnProperty("success_message")) {
                        showAlert('success', params.success_message);
                    }
                } else {
                    if (data.hasOwnProperty("message") && !params.hasOwnProperty("error_message")) {
                        showAlert('error', data.message);
                    } else {
                        showAlert('error', error_message);
                    }
                }
            }
            if (params.hasOwnProperty("success_callback")) {
                params.success_callback(data);
            }
        },
        complete: function () {
            blockElement ? unblockContainer(blockElement) : unblockPage();
            if (params.hasOwnProperty("complete_callback")) {
                params.complete_callback();
            }
        }
    });
}

function showAlert(type, message) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    switch (true) {
        case (type === 'success'):
            toastr.success(message, "Aviso!");
            break;
        case (type === 'info'):
            toastr.info(message, "Aviso!");
            break;
        case (type === 'warning'):
            toastr.warning(message, "Aviso!");
            break;
        case (type === 'error'):
            toastr.error(message, "Aviso!");
            break;
    }
}


function validationHighlight(element) {
    $(element).parent().addClass('has-danger').removeClass('has-success');
}

function validationSuccess(element) {
    $(element).parent().removeClass('has-danger').removeClass('has-success');
}

function validationErrorPlacement(error, element) {
    if (element.parent('.input-group').length) {
        error.insertAfter(element.parent());
    } else {
        element.parent().append(error);
    }
}

function initSelect2(el, options) {
    var default_options = {
        placeholder: options.placeholder ? options.placeholder : '- Seleccione -',
        disabled: options.disabled ? options.disabled : false,
        multiple: options.multiple ? options.multiple : false,
        dropdownParent: options.dropdownParent ? options.dropdownParent : null,
        allowClear: true,
        ajax: {
            url: options.ajax.url,
            dataType: options.ajax.dataType ? options.ajax.dataType : 'json',
            delay: 250,
            data: function (params) {
                var parameters = {
                    q: params.term,
                    page: params.page,
                };
                if (options.ajax.params && $.isArray(options.ajax.params)) {
                    $.each(options.ajax.params, function (index, value) {
                        if (value.type == 'selector') {
                            parameters[value.name] = value.element.val();
                        }
                        else if (value.type == 'value') {
                            parameters[value.name] = value.element;
                        }
                    });

                }
                return parameters;
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                return {
                    results: data
                };
                // params.page = params.page || 1;
                //
                // return {
                //     results: data.items,
                //     pagination: {
                //         more: (params.page * 30) < data.total_count
                //     }
                // };
            },
            cache: true
        },
        width: options.width ? options.width : '100%'
        // escapeMarkup: function (markup) {
        //     return markup;
        // }, // let our custom formatter work
        // minimumInputLength: 1,
        // templateResult: formatRepo,
        // templateSelection: formatRepoSelection
    };
    return el.select2(default_options);
}

function setSelectedValueSelect2(el, url, selectedValue) {
    var parameter = '';
    if (el[0].multiple) {
        parameter = url + '?ids=' + selectedValue;
    } else {
        parameter = url + '?id=' + selectedValue;
    }
    ajaxRequest(parameter, {
        type: 'GET',
        error_message: 'Error al cargar elemento seleccionado',
        success_callback: function (data) {
            // create the option and append to Select2
            if (data.length > 0) {
                $.each(data, function (index, value) {
                    var option = new Option(data[index].text, data[index].id, true, true);
                    el.append(option).trigger('change');
                })

            }
        }
    });
}

function initDatableAjax(el, options) {
    var default_option = {
        data: {
            type: 'remote',
            source: {
                read: {
                    url: options.ajax.url,
                    method: options.ajax.method ? options.ajax.method : 'GET',
                    // custom headers
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    params: {
                        query: options.ajax.params || {}
                    },
                    map: function (raw) {
                        // sample data mapping
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    }
                }
            },
            pageSize: options.pageSize ? options.pageSize : 10,
            saveState: {
                cookie: true,
                webstorage: true
            },
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true
        },
        layout: {
            theme: 'default',
            class: 'm-datatable--brand',
            scroll: true,
            height: null,
            footer: false,
            header: true,
            smoothScroll: {
                scrollbarShown: true
            },
            spinner: {
                overlayColor: '#000000',
                opacity: 0,
                type: 'loader',
                state: 'brand',
                message: true
            },
            icons: {
                sort: {asc: 'la la-arrow-up', desc: 'la la-arrow-down'},
                pagination: {
                    next: 'la la-angle-right',
                    prev: 'la la-angle-left',
                    first: 'la la-angle-double-left',
                    last: 'la la-angle-double-right',
                    more: 'la la-ellipsis-h'
                },
                rowDetail: {expand: 'fa fa-caret-down', collapse: 'fa fa-caret-right'}
            }
        },
        sortable: true,
        pagination: true,
        search: options.search || {},
        // columns definition
        columns: options.columns,
        toolbar: {
            layout: ['pagination', 'info'],
            placement: ['bottom'],  //'top', 'bottom'
            items: {
                pagination: {
                    type: 'default',
                    pages: {
                        desktop: {
                            layout: 'default',
                            pagesNumber: 6
                        },
                        tablet: {
                            layout: 'default',
                            pagesNumber: 3
                        },
                        mobile: {
                            layout: 'compact'
                        }
                    },
                    navigation: {
                        prev: true,
                        next: true,
                        first: true,
                        last: true
                    },
                    pageSizeSelect: [5, 10, 20, 30, 50, 100]
                },
                info: true
            }
        },
        translate: {
            records: {
                processing: 'Espere ...',
                noRecords: 'No hay resultado'
            },
            toolbar: {
                pagination: {
                    items: {
                        default: {
                            first: 'Inicio',
                            prev: 'Anterior',
                            next: 'Siguiente',
                            last: 'Ultimo',
                            more: 'Mas páginas',
                            input: 'Numero de página',
                            select: 'Registros por página'
                        },
                        info: 'Mostrando {{start}} - {{end}} de {{total}} registros'
                    }
                }
            }
        }
    };
    return el.mDatatable(default_option);
}

function initDataTable(el, config) {
    config = config || {};
    return el.DataTable({
        responsive: true,
        language: {
            sProcessing: "Cargando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            },
            paginate: {
                previous: '<i class="demo-psi-arrow-left"></i>',
                next: '<i class="demo-psi-arrow-right"></i>'
            }
        },
        rowCallback: function (row, data, dataIndex) {
            if (typeof config.rowCallback !== 'undefined' && typeof config.rowCallback === 'function') {
                config.rowCallback(row, data, dataIndex);
            }
        },
        initComplete: function (settings, json) {
            if (typeof config.initComplete !== 'undefined' && typeof config.initComplete === 'function') {
                config.initComplete(settings, json);
            }
        },
        drawCallback: function (settings) {
            var api = this.api();
            if (typeof config.drawCallback !== 'undefined' && typeof config.drawCallback === 'function') {
                config.drawCallback(settings, api);
            }
        }
    });
}

function truncateString(str, length) {
    return str.length > length ? str.substring(0, length - 3) + '...' : str
}

$(function () {
    jQuery.extend(jQuery.validator.messages, {
        required: 'Este campo es obligatorio.',
        textOnly: 'Este campo admite s&oacute;lo texto.',
        alphaNumeric: 'Este campo admite s&oacute;lo caracteres alfa - num&eacute;ricos.',
        date: 'Este campo tiene un formato dd/mm/YYYY.',
        dateISO: 'Este campo tiene un formato YYYY-mm-dd.',
        digits: 'Este campo admite solo d&iacute;gitos.',
        number: 'Este campo admite solo n&uacute;meros enteros o decimales.',
        alphaNumericSpecial: 'Este campo admite s&oacute;lo caracteres alfa - num&eacute;ricos.',
        email: 'Este campo admite el formato <i>direccion@dominio.com</i>.',
        url: "Ingrese un URL v&aacute;lido.",
        numberDE: "Bitte geben Sie eine Nummer ein.",
        percentage: "Este campo debe tener un porcentaje v&aacute;lido.",
        validarUserName: "Nombre de Usuario no v\u00E1lido.",
        creditcard: "Ingrese un n&uacute;mero de tarjeta de cr&eacute;dito v&aacute;lido.",
        equalTo: "Las direcciones de correo no coinciden.",
        notEqualTo: "Ingrese un valor diferente.",
        accept: "Ingrese un valor con una extensi&oacute;n v&aacute;lida.",
        maxlength: $.validator.format("Este campo debe tener m&aacute;ximo {0} caracteres."),
        minlength: $.validator.format("Este campo debe tener m&iacute;nimo {0} caracteres."),
        rangelength: $.validator.format("Ingrese un valor entre {0} y {1} caracteres."),
        range: $.validator.format("Ingrese un valor entre {0} y {1}."),
        max: $.validator.format("Ingrese un valor menor o igual a {0}."),
        min: $.validator.format("Ingrese un valor mayor o igual a {0}."),
        cedulaEcuador: "Por favor ingrese una c&eacute;dula v&aacute;lida.",
        dateLessThan: $.validator.format("Ingrese una fecha menor o igual a {0}."),
        dateMoreThan: $.validator.format("Ingrese una fecha mayor o igual a {0}."),
        minStrict_zero: 'El valor debe ser mayor o igual a cero',
        minStrict: 'Ingrese un valor mayor a cero',
        dateLessThanDate: 'La fecha "Desde" debe ser menor o igual a la fecha en el campo "Hasta".',
        extension: 'Ingrese un archivo con una extensi\u00F3n jpg, jpeg o png.'
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.fn.datepicker.dates['en'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        clear: "Limpiar",
        format: "yyyy-mm-dd",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };

    $('.m-menu__item--active').parents('li').addClass('m-menu__item--open');
});