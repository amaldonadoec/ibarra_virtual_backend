{!! Form::model($model, array('id' => 'entity_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-vertical', 'method' => $method)) !!}
<div class="m-portlet__body">
    <div class="row">
        <div class="col-md-6">
            {!! Form::hidden('entity_id', $model->id,['id'=>'entity_id']) !!}
            <div class="form-group row">
                {!! Form::label('name','*Nombre:', array('class' => 'col-form-label col-md-3')) !!}
                <div class="col-md-9">
                    {!! Form::text('name', $model->name, array('class' => 'form-control m-input', 'autocomplete' =>
                    'off', 'placeholder' => 'ej. Iglesia San Luis', 'maxlength' => '45')) !!}
                </div>
            </div>
            <div class="form-group ">
                {!! Form::label('categories[]','*Categorías:', array('class' => 'col-form-label ')) !!}
                {!! Form::select('categories[]',[''=>'Selecione']+$categories, $model->categories->pluck('id')->toArray(),
                 array('class' => 'form-control m-input', 'multiple' =>'multiple',
                 'id'=>'categories')) !!}
            </div>
            <div class="form-group ">
                {!! Form::label('description','Descripción:', array('class' => 'col-form-label')) !!}
                {!! Form::textarea('description', $model->description, array('class' => 'form-control m-input', 'autocomplete' =>
                'off', 'placeholder' => 'ej. Iglesias',)) !!}
            </div>
            @if ($model->id)
                <div class="form-group ">
                    {!! Form::label('status','*Estado:', array('class' => 'col-form-label col-md-12')) !!}
                    <div class="col-md-12">
                        {!! Form::select('status', array( 1 => 'Activo', 0 => 'Inactivo'),$model->status,array('class' => 'form-control m-input') ) !!}
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            {!! Form::hidden('latitude',$model->location ? $model->location->getLat() : null, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. -79.9632541', 'maxlength' => '64', 'readOnly'=>true,
            'id'=>'latitude')) !!}
            {!! Form::hidden('longitude', $model->location ? $model->location->getLng() : null, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. 56.9632541', 'maxlength' => '64', 'readOnly'=>true,
            'id'=>'longitude')) !!}
            {!! Form::text('main_street', $model->main_street, array('class' => 'form-control m-input',
             'autocomplete' =>'off', 'onFocus'=>"geolocate()", 'placeholder' => 'ej. Buscar dirección',
             'id'=>'main_street')) !!}
            <div style="width:auto;height: 400px;" id="map">
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h4>Imágenes</h4>
            <div class="m-dropzone dropzone m-dropzone--primary"
                 id="mydropzone"
                 data-accepte-files=".png,.jpg,.jpeg"
            >
                <div class="dz-default dz-message">
                    <span></span>
                </div>
                <div class="m-dropzone__msg dz-message needsclick">
                    <h3 class="m-dropzone__msg-title">Suelta tus imágenes aquí o haz clic para cargar</h3>
                    <span class="m-dropzone__msg-desc"></span>
                </div>
                @foreach($model->images as $image)
                    <div class="dz-preview dz-image-preview">
                        <div class="dz-image">
                            <img data-dz-thumbnail="" alt="{{$image->file_name}}"
                                 src="{{$image->url}}?h=120">
                        </div>
                        <div class="dz-details">
                            <div class="dz-filename">
                                <span data-dz-name="">{{$image->file_name}}</span>
                            </div>
                        </div>
                        <div class="dz-success-mark"></div>
                        <a class=" btn red btn-sm btn-block"
                           onclick="deleteMultimedia(this,{{$image->id}})"
                           href="javascript:undefined;"
                           data-dz-remove="">Eliminar</a>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="col-md-6">
            <h4>Audio</h4>
            <div class="m-dropzone dropzone m-dropzone--primary"
                 id="wrapper_audio"
                 data-accepte-files=".mp3"
            >
                <div class="m-dropzone__msg dz-message needsclick">
                    <h3 class="m-dropzone__msg-title">Suelta aquí o haz clic para cargar</h3>
                    <span class="m-dropzone__msg-desc"></span>
                </div>

                <div class="dz-default dz-message">
                    <span></span>
                </div>
                @if($model->audio)
                    <div class="dz-preview dz-file-preview audio_exists"
                         style="width: 100%;margin: 0px;min-height: 30px;">
                        <div class="dz-details" style="padding: 0px;">
                            <div class="dz-filename" style="display: flex;">
                                <span data-dz-name
                                      style="background-color: #9798a0;color: white;display: flex;flex: 1;">
                                    {{$model->audio->file_name}}
                                </span>
                                <a class="dz-remove btn red btn btn-xs red" href="javascript:undefined;"
                                   onclick="deleteMultimedia(this,{{$model->audio->id}})"
                                   data-dz-remove="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="hide" id="preview_file" style="display: none">
    <div class="dz-preview dz-file-preview" style="width: 100%;margin: 0px;min-height: 30px;">
        <div class="dz-details" style="padding: 0px;">
            <div class="dz-filename" style="display: flex;">
                <span data-dz-name style="background-color: #9798a0;color: white;display: flex;flex: 1;"></span>
                <a class="dz-remove btn red btn btn-xs red" href="javascript:undefined;" data-dz-remove="">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
