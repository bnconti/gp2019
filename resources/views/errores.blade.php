@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading"><i class="fas fa-exclamation-circle fa-fw"></i>¡Error!</h4>
        <hr>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="cerrar">
            <span aria-hidden="true">&times;</span>
        </button> 
    </div>
@endif