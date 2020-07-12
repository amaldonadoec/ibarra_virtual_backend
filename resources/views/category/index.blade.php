@section('content')
    @include('partials.admin_view',[
    'title'=>'Administración de categorias',
    'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'category_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newCategory()',
        'color'=>'btn-primary'
        ],
      ]
    ])
    @include('partials.modal',[
    'title'=>'Crear Categoría',
    'id'=>'modal',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>'category_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])
    <input id="action_get_form" type="hidden" value="{{ action("Catalogs\CategoryController@getFormCategory") }}"/>
    <input id="action_unique_name" type="hidden" value="{{ action("Catalogs\CategoryController@postIsNameUnique") }}"/>
    <input id="action_save_category" type="hidden" value="{{ action("Catalogs\CategoryController@postSave") }}"/>
    <input id="action_load_categories" type="hidden" value="{{ action("Catalogs\CategoryController@getListCategories") }}"/>
@endsection
@section('additional-scripts')
    <script src="{{ asset('js/app/category/index.js') }}" type="text/javascript"></script>
@endsection
