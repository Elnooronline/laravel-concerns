@php($hash = uniqid())
@php($modalId = 'delete-modal-'.$present->entity->getResourceName().'-'.$entity->getKey().'-'.$hash)
@php($formId = 'delete-form-'.$present->entity->getResourceName().'-'.$entity->getKey().'-'.$hash)

<a class="btn btn-danger" data-toggle="modal" href="#{{ $modalId }}">
    <i class="fa fa-trash"></i>
    @lang('lists.actions.delete')
</a>
<div class="modal fade" id="{{ $modalId }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
                    @lang("{$present->entity->getResourceName()}.dialogs.delete.title")
                </h4>
			</div>
			<div class="modal-body">
                @lang("{$present->entity->getResourceName()}.dialogs.delete.info")
                {{ BsForm::delete($present->getDeleteUrl(), ['id' => $formId]) }}
                {{ BsForm::close() }}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
                    @lang("{$present->entity->getResourceName()}.dialogs.delete.cancel")
                </button>
				<button type="submit" form="{{ $formId }}" class="btn btn-primary">
                    @lang("{$present->entity->getResourceName()}.dialogs.delete.confirm")
                </button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
