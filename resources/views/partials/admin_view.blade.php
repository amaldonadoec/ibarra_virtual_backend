<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                @if(isset($icon))
                    <span class="m-portlet__head-icon">
                    {!! $icon !!}
                    </span>
                @endif
                <h3 class="m-portlet__head-text m--font-brand">
                    {{$title}}
                </h3>
            </div>
        </div>

        @if(isset($action_buttons) && is_array($action_buttons))
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    @foreach( $action_buttons as $item_button)
                        <li class="m-portlet__nav-item">
                            <a href="#" onclick="{{$item_button['handler_js']}}"
                               class="m-portlet__nav-link btn {{isset($item_button['color'])? $item_button['color']: 'btn-primary'}} m-btn m-btn--pill m-btn--air">
                                <span>
                                    {!! $item_button['icon'] !!}
                                    {{ $item_button['label'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="m-portlet__body {{isset($class_body)?$class_body:''}}">
    @if(isset($searchable)&&$searchable)
        <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-12">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" placeholder="Buscar..."
                                           id="{{$id_table}}_search">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
        @endif
        @if(isset($form_id))
            {!! Form::open(array('id' => $form_id,'class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => (isset($method)?$method:'POST'))) !!}
        @endif
        <div id="{{$id_table? $id_table: ''}}" class="datatable "></div>
        @if(isset($form_id))
            {!! Form::close() !!}
        @endif
    </div>
</div>