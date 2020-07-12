{!! Form::model($user, array('id' => 'user_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
{!! Form::hidden('user_id', $user->id,['id'=>'user_id']) !!}
<div class="form-group m-form__group row">
    {!! Form::label('name','* Nombre:', array('class' => 'col-form-label col-md-3')) !!}
    <div class="col-md-9">
        {!! Form::text('name', $user->name, array('class' => 'form-control m-input ', 'autocomplete' =>
        'off', 'placeholder' => 'ej. Operador', 'maxlength' => '64')) !!}
    </div>
</div>
<div class="form-group m-form__group row">
    {!! Form::label('name','* Email:', array('class' => 'col-form-label col-md-3')) !!}
    <div class="col-md-9">
        {!! Form::text('email', $user->email, array('class' => 'form-control m-input ', 'autocomplete' =>
        'off','id'=>'email', 'placeholder' => 'ej. operador@lovekiss.me', 'maxlength' => '64')) !!}
    </div>
</div>


<div class="form-group m-form__group row">
    {!! Form::label('name','* Roles:', array('class' => 'col-form-label col-md-3')) !!}
    <div class="col-md-9">
        {!! Form::select('role[]',$roles, $user->roles()->pluck('id')->toArray(), array('class' => 'form-control', 'id'=>'role','multiple'=>'multiple' )) !!}
    </div>
</div>
@if ($user->id)
    <details>
        <summary>Cambiar contraseña</summary>
        <div class="form-group m-form__group row">
            {!! Form::label('name','* Contraseña:', array('class' => 'col-form-label col-md-3')) !!}
            <div class="col-md-9">
                {!! Form::password('password', array('class' => 'form-control m-input ', "id"=>'password', 'autocomplete' =>
                'off', 'maxlength' => '64')) !!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label('name','* Confirmar Contraseña:', array('class' => 'col-form-label col-md-3')) !!}
            <div class="col-md-9">
                {!! Form::password('confirm_password',  array('class' => 'form-control m-input ', 'autocomplete' =>
                'off', "id"=>'confirm_password',)) !!}
            </div>
        </div>
    </details>
    <br>
@else
    <div class="form-group m-form__group row">
        {!! Form::label('name','* Contraseña:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::password('password', array('class' => 'form-control m-input ', "id"=>'password', 'autocomplete' =>
            'off', 'maxlength' => '64')) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('name','* Confirmar Contraseña:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::password('confirm_password',  array('class' => 'form-control m-input ', 'autocomplete' =>
            'off', "id"=>'confirm_password',)) !!}
        </div>
    </div>
@endif
@if ($user->id)
    <div class="form-group m-form__group row">
        {!! Form::label('status','* Estado:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::select('status', array( 1 => 'Activo', 0 => 'Inactivo'),$user->status,array('class' => ' m-input form-control') ) !!}
        </div>
    </div>
@endif
{!! Form::close() !!}