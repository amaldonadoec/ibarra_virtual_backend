@section('content')
    @include('partials.admin_view',[
    'title'=>'Administración de sitios',
    'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'entity_table',
    'searchable'=>true,
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'handlerNew()',
        'color'=>'btn-primary'
        ],
      ]
    ])
    @include('partials.modal',[
    'title'=>'Crear Sucursal',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'entity_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Catalogs\SiteController@getForm") }}"/>
    <input id="action_unique_name" type="hidden" value="{{ action("Catalogs\SiteController@postIsNameUnique") }}"/>
    <input id="action_save" type="hidden" value="{{ action("Catalogs\SiteController@postSave") }}"/>
    <input id="action_load" type="hidden" value="{{ action("Catalogs\SiteController@getList") }}"/>
@endsection
@section('additional-scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}&libraries=places&region=EC"></script>
    <script src="{{ asset('js/plugins/gmaps/gmaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app/site/index.js') }}" type="text/javascript"></script>
@endsection
