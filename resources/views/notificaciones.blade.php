@if ($message = Session::get('exito'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert"aria-label="cerrar">
                <span aria-hidden="true">&times;</span>
        </button> 	
        <strong><i class="fas fa-check-circle fa-fw"></i>{{ $message }}</strong>
</div>
@endif
