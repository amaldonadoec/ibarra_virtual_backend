<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rules
    |--------------------------------------------------------------------------
    |
    | The following language lines contain messages returned from the API
    |
    */

    'error' => 'Ha ocurrido un error',
    'validation' => 'Ha ocurrido un error de validación',
    'success' => 'OK',
    'directCredit' => [
        'insufficientQuota' => 'El cupo disponible es insuficiente para realizar la transacción',
        'invoiceAlreadyExists' => 'No puede realizar un débito de una factura existente',
        'invoiceDoesNotExists' => 'No existe una factura con el número de factura proporcionado',
        'inactiveCompany' => 'La empresa asociada a la factura no se encuentra activa',
        'overdue' => 'La empresa tiene una deuda pendiente',
        'maxQuota' => 'El cupo máximo de la empresa es insuficiente pera realizar la transacción',
        'transactionsDetected' => 'Ya existen transacciones relacionadas al número de factura proporcionado',
        'notAllowedPaymentDays' => 'La empresa no dispone de días de gracia asignados',
        'doesNotHaveCreditRequest' => 'La empresa no dispone de un credito directo aprobado',
        'invalidTransaction' => 'No existe ninguna transacción de tipo DEBITO con el identificador proporcionado',
        'invoiceDoesNotMatch' => 'Los datos enviados no coinciden con los de la factura',
        'notAllowedTransaction' => 'No puede realizar esta transacción, el registro del débito aún no ha sido finalizado'
    ],
    'quotaRequest' => [
        'minAmount' => 'El cupo solicitado debe ser mayor al otorgado actualmente'
    ],
    'overdueAuthorization' => [
        'alreadyExists' => 'La empresa ya tiene una autorización disponible registrada',
        'delete' => 'La autorización ha sido cancelada exitosamente'
    ],
    'billingData' => [
        'doesNotExists' => 'La empresa no dispone de datos de facturación'
    ],
    'invitation' => [
        'user_role_id' => 'No tiene permisos para enviar invitaciones',
        'uid' => 'El usuario no pertenece a la empresa',
        'associated' => 'El usuario ha sido asociado a ',
        'companies' => ' empresa(s)',
        'nonAssociated' => 'El usuario no tiene invitaciones disponibles'
    ]
];
