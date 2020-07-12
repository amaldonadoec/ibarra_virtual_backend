<div class="modal fade" id="{{isset($id)? $id:'modal'}}" role="dialog"
     aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog {{isset($size)? $size:''}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{$title}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container_modal">
                    @if(isset($static_content))
                        {!! $static_content !!}
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Cerrar
                </button>
                @foreach($action_buttons as $item_button)
                    <button type="{{isset($item_button['type'])?$item_button['type']:'button'}}"
                            form="{{isset($item_button['form'])?$item_button['form']:''}}"
                            id="{{isset($item_button['id'])? $item_button['id']: ''}}"
                            class="btn {{isset($item_button['color'])? $item_button['color']: 'btn-primary'}}"
                            onclick="{{isset($item_button['handler_js'])?$item_button['handler_js']:''}}">
                        {{$item_button['label']}}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>