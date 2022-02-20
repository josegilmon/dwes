@extends('app')
@section('titulo', "Login")
@section('cabecera')
@endsection
@section('encabezado', "Login")
@section('contenido')
<div style="width:300px;" class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Login</h3>
        </div>
        <div class="card-body">
            <form name='login' method='POST' action='<?= $_SERVER['PHP_SELF'] ?>'>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="<?= "form-control " . ((isset($errorLoginForm) && (empty($nombreUsuario))) ? "is-invalid" : "") ?>" placeholder="usuario" name='usuario' >
                    <div class="invalid-feedback">
                        <p>Introduce el usuario</p>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="<?= "form-control " . ((isset($errorLoginForm) && (empty($pass))) ? "is-invalid" : "") ?>" placeholder="contraseña" name='pass' >
                    <div class="invalid-feedback">
                        <p>Introduce el password</p>
                    </div>
                </div>
                <?php if (isset($errorCredenciales) && $errorCredenciales): ?>
                    <div class="alert alert-danger" role="alert">
                        Credenciales incorrectos
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <input type="submit" value="Login" class="btn float-right btn-success" name='login'>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
