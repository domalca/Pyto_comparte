@extends('app')
@section('titulo', "Login")

@section('cabecera')
@endsection      
@section('encabezado', "")
@section('contenido')
<div class="container-md mt-5">
    <div class="d-flex flex-column align-items-center">
        @if(isset($nuevoUsu))
        <div class="d-flex justify-content-center">
            Nuevo Usuario Creado
        </div>
        
        @endif
        <div id='mensaje' class="d-none alert alert-danger my-3" role="alert">
            Credenciales incorrectos
        </div>
        <div class="card ">
            <div class="card-header">
                <h3><i class="bi bi-gear p-2"></i>Login</h3>
            </div>
            <div class="card-body">
                <div id="mensaje" class="d-none alert alert-danger my-3" role="alert">
                    Credenciales incorrectos
                </div>
                <form id="login" method="POST" action="portada.php">
                    <div class="input-group my-2">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" placeholder="usuario" id='usuario' name="usuario" value="<?= $usuario ?? '' ?>" required>
                    </div>
                    <div class="input-group my-2">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control" placeholder="contraseña" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn btn-success" name="login">
                    </div>
                    
                </form>
                <a href="index.php?registro" class="float float-end d-inline-flex m-3">Registrate</a>       

            </div>
        </div>
    </div>
    <div class="form-group">
    
    </div>
</div>
@endsection
@section ('scripts')
<script src="./js/validar.js"></script>
@endsection
