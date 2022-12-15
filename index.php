<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=3.2.0">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Iniciar Sesión</p>
                <form action="ingresar" method="post" id="form_login">
                    <div class="input-group mb-3">
                        <input type="text" id = "name_user" name = "name_user" class="form-control" placeholder="Usuario">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id = "pass_user" name = "pass_user" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Recordame
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="social-auth-links text-center mb-3">
                        <a href="#" class="btn btn-block btn-primary" id="btn_ingresar">
                            <i class="fas fa-sign-in-alt mr-2"></i> Ingresar
                        </a>
                        <p class="mb-0">
                            <a href="#" class="text-center">Olvidé mi contraseña</a>
                        </p>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <img src="dist/img/login.jpg"
        style="position: absolute; margin: 0px; padding: 0px; border: none; width: 1680px; height: 945px; max-height: none; max-width: none; z-index: -999999; left: 0px; top: 0px;">
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js?v=3.2.0"></script>
    <script src="pages_js/index_js.js"></script>
</body>

</html>