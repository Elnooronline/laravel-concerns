<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span> @lang('lists.actions.options')
    </button>
    <ul class="dropdown-menu">
        @if($present['show'])
            <li>
                <a href="{{ route("dashboard.$resource.show", $entity) }}">
                    <i class="fa fa-eye"></i>
                    @lang('lists.actions.show')
                </a>
            </li>
        @endif
        @if($present['edit'])
            <li>
                <a href="{{ route("dashboard.$resource.edit", $entity) }}">
                    <i class="fa fa-edit"></i>
                    @lang('lists.actions.edit')
                </a>
            </li>
        @endif
            <li>
                <a data-toggle="modal" href="#send-message-{{ $entity->id }}">
                    <i class="fa fa-paper-plane-o"></i>
                    @lang('chat::messages.actions.new')
                </a>
            </li>
        @if($present['delete'])
            <li>
                <a
                        href="#"
                        class="form-confirm"
                        data-form="delete-form-{{ $entity->getKey() }}"
                        data-type="warning"
                        data-title="@lang("$resource.dialogs.delete.title")"
                        data-text="@lang("$resource.dialogs.delete.info")"
                        data-confirm-text="@lang("$resource.dialogs.delete.confirm")"
                        data-cancel-text="@lang("$resource.dialogs.delete.cancel")"
                >
                    <i class="fa fa-trash"></i>
                    @lang('lists.actions.delete')
                </a>

                {{ BsForm::delete(route("dashboard.$resource.destroy", $entity), [
                    'id' => 'delete-form-'.$entity->getKey()
                ]) }}
                {{ BsForm::close() }}
            </li>
        @endif
    </ul>
</div>
<div class="modal fade" id="send-message-{{ $entity->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ $entity->name }}
                </h4>
            </div>
            <div class="modal-body">
                {{ BsForm::resource($resource)
                    ->post(route('dashboard.users.send-message', $entity), [
                        'id' => "send-message-form-{$entity->id}"
                    ]) }}

                {{ BsForm::textarea('message') }}

                {{ BsForm::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    @lang('forms.close')
                </button>
                <button type="submit" form="send-message-form-{{ $entity->id }}" class="btn btn-primary">
                    @lang('chat::messages.actions.send')
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->