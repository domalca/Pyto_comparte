@extends('app')
@section('titulo', "Registro")
@section('cabecera')
@endsection
@section('encabezado',       
)
@section('contenido')

<div class="d-flex justify-content-end">
    <a class="btn btn-warning" href="index.php">Volver</a>
</div>
<div class="d-flex justify-content-center m-5">
    <h3><i class="bi bi-gear p-2 "></i>Registro</h3>
</div>
<div class="d-flex justify-content-center">    

    <form method="POST" action="registro.php" enctype="multipart/form-data" novalidate="true">

        <div class="form-group">
            <label for="usuario">Usuario: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" class="<?= "form-control" . ((isset($errorNombre)) || (isset($nombreRepe))) ? ($errorNombre || $nombreRepe) ? "is-invalid" : "is-valid" : "" ?>" id='usuario' name="usuario" value="<?= $nombreUsuario ?? '' ?>" required>&nbsp;*
                <div class=" invalid-feedback">
                @if($errorNombre)
                <p>usuario debe contener entre 3 y 12 caracteres no especiales </p>
                @else
                <p>usuario existente</p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2">
            <label for="password">Contraseña: </label>&nbsp;
            <input type="password" class="<?= "form-control" . (isset($errorPass)) ? ($errorPass ? "is-invalid" : "is-valid") : "" ?>" id="password"
                   value="<?= isset($errRegistro) ? $pass : '' ?>"name="password" required>&nbsp;*
            <div class=" invalid-feedback">
                <p>contraseña debe contener entre al menos 6 caracteres con al menos 1 de ellos especial</p>
            </div>

        </div>
        <div class="form-group mt-2">
            <label for="email">Correo E.: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="email" class="<?= "form-control" . (isset($errorEmail)) ? ($errorEmail ? "is-invalid" : "is-valid") : "" ?>" id="email"
                   value="<?= isset($errRegistro) ? $email : "" ?>"name="email">
            <div class=" invalid-feedback">
                <p>Introducir email válido</p>
            </div>
        </div>
        <div class="form-group mt-2">
            <label for="fPerfil">Foto perfil: </label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" class="<?= "form-control" . (isset($errorFoto)) ? ($errorFoto ? "is-invalid" : "is-valid") : "" ?>" id="fPerfil"
                   name="fPerfil">
            <div class=" invalid-feedback">
                <p>nombre del archivo ya existe...</p>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <input type="submit" value="Registrar" class="btn float-right btn-success" name="registro">
        </div>

    </form>

</div>



@endsection
@section ('scripts')

@endsection
