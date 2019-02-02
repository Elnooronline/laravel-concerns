@php($hash = uniqid())
@php($modalId = 'delete-modal-'.$entity->getResourceName().'-'.$entity->getKey().'-'.$hash)
@php($formId = 'delete-form-'.$entity->getResourceName().'-'.$entity->getKey().'-'.$hash)

<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span> @lang('LaravelConcerns::lists.actions.options')
    </button>
    <ul class="dropdown-menu">
        @if($authorize['show'])
            <li>
                <a href="{{ $present->getShowUrl() }}">
                    <i class="fa fa-eye"></i>
                    @lang('LaravelConcerns::lists.actions.show')
                </a>
            </li>
        @endif
        @if($authorize['edit'])
            <li>
                <a href="{{ $present->getEditUrl() }}">
                    <i class="fa fa-edit"></i>
                    @lang('LaravelConcerns::lists.actions.edit')
                </a>
            </li>
        @endif
        @if($authorize['delete'])
            <li>
                <a data-toggle="modal" href="#{{ $modalId }}">
                    <i class="fa fa-trash"></i>
                    @lang('LaravelConcerns::lists.actions.delete')
                </a>
            </li>
        @endif
    </ul>
    @if($authorize['delete'])
        <div class="modal fade" id="{{ $modalId }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">
                            @lang("{$entity->getResourceName()}.dialogs.delete.title")
                        </h4>
                    </div>
                    <div class="modal-body">
                        @lang("{$entity->getResourceName()}.dialogs.delete.info")
                        {{ BsForm::delete($present->getDeleteUrl(), ['id' => $formId]) }}
                        {{ BsForm::close() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            @lang("{$entity->getResourceName()}.dialogs.delete.cancel")
                        </button>
                        <button type="submit" form="{{ $formId }}" class="btn btn-primary">
                            @lang("{$entity->getResourceName()}.dialogs.delete.confirm")
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
</div>