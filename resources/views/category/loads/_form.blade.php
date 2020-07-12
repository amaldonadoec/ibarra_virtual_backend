{!! Form::model($category, array('id' => 'category_form','class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => $method)) !!}
<div class="m-portlet__body">
    {!! Form::hidden('category_id', $category->id,['id'=>'category_id']) !!}
    <div class="form-group m-form__group row">
        {!! Form::label('name','* Nombre:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::text('name', $category->name, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. Iglesias', 'maxlength' => '64')) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('description','Descripción:', array('class' => 'col-form-label col-md-3')) !!}
        <div class="col-md-9">
            {!! Form::textarea('description', $category->description, array('class' => 'form-control m-input', 'autocomplete' =>
            'off', 'placeholder' => 'ej. Iglesias')) !!}
        </div>
    </div>
    @if ($category->id)
        <div class="form-group m-form__group row">
            {!! Form::label('status','* Estado:', array('class' => 'col-form-label col-md-3')) !!}
            <div class="col-md-9">
                {!! Form::select('status', array( 1 => 'Activo', 0 => 'Inactivo'),$category->status,array('class' => 'form-control m-input') ) !!}
            </div>
        </div>
    @endif
    <h4>Imagen</h4>
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
        @foreach([$category->image()] as $image)
            @if($image)
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
            @endif
        @endforeach
    </div>
</div>

{!! Form::close() !!}
