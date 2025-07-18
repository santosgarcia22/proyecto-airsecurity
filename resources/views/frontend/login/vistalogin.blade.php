<!DOCTYPE html>
<html lang="es">

<head>
    <title>Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/login/bootstrap.min.css') }}">

    <!-- icono del sistema -->
    <link href="{{ asset('images/Airsecurity.png') }}" rel="icon">
    <!-- libreria -->
    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" type="text/css" rel="stylesheet" />

    <!-- estilo de toast -->
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <!-- estilo de sweet -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">


   <style>
    body, html {
        min-height: 100vh;
        background: linear-gradient(135deg,rgb(252, 51, 51) 0%,rgb(133, 142, 156) 100%);
        font-family: 'Roboto', sans-serif;
    }
    .login-overlay {
        min-height: 100vh;
        background: rgba(30, 41, 59, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 40px rgba(30, 30, 238, 0.22), 0 2px 4px rgba(0,0,0,0.03);
        padding: 48px 36px 36px 36px;
        width: 100%;
        max-width: 380px;
        position: relative;
        animation: fadeInDown 1s;
    }
    @keyframes fadeInDown {
        from { transform: translateY(-40px); opacity: 0;}
        to   { transform: translateY(0); opacity: 1;}
    }
    .login-logo {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }
    .login-logo img {
        width: 250px;
        border-radius: 18px;
        /* box-shadow: 0 3px 12px rgba(243, 8, 8, 0.78);    es para poner una sobre a la img de airsecurity  */ 
        background: #fff;
        padding: 10px;
    }
    .login-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        text-align: center;
        margin-bottom: 6px;
        margin-top: 18px;
        letter-spacing: 2px;
    }
    .login-subtitle {
        font-size: 1.04rem;
        font-weight: 500;
        color: #6c757d;
        text-align: center;
        margin-bottom: 28px;
        letter-spacing: 1px;
    }
    .form-label {
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 3px;
        letter-spacing: .5px;
        padding: 0 0 0 50px;
    }
    .form-control-lg {
        border-radius: 12px;
        font-size: 1.02rem;
        padding: 20px 16px;
        margin-bottom: 16px;
        background:rgb(213, 222, 231);
        border: 1px solidrgb(172, 177, 184);
    }
    .form-control-lg:focus {
        box-shadow: 0 0 0 2px #2563eb22;
        border-color: #2563eb;
        background: #fff;
    }
    .input-group-text {
        background: transparent;
        border: none;
        color:rgb(239, 16, 53);
        font-size: 1.16rem;
        padding-right: 0;
    }
    .btn-login {
        width: 100%;
        padding: 12px 0;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.06rem;
        letter-spacing: 1.5px;
        background: linear-gradient(90deg,rgb(242, 20, 12) 60%,rgb(127, 134, 137) 100%);
        color: #fff;
        border: none;
        box-shadow: 0 3px 12px rgba(30,41,59,0.10);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-login:hover, .btn-login:focus {
        background: linear-gradient(90deg,rgb(232, 96, 75) 60%,rgb(126, 138, 142) 100%);
        box-shadow: 0 8px 24px rgba(30,41,59,0.15);
        color: #fff;
    }
    @media (max-width: 540px) {
        .login-card { padding: 28px 8px 24px 8px;}
    }

    .input-group-text{
        margin: 8px;
    }
</style>
</head>

<body>
 <div class="login-overlay">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('images/Airsecurity.png') }}" alt="Logo AirSecurity">
            </div>
            <div class="login-title">Panel de Acceso</div>
            <div class="login-subtitle">Inicia sesión para continuar</div>
            <form autocomplete="off">
                <label for="usuario" class="form-label">Usuario</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input class="form-control form-control-lg" id="usuario" type="text" autocomplete="off" placeholder="Nombre de usuario">
                </div>
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input class="form-control form-control-lg" id="password" type="password" placeholder="Ingresa tu contraseña">
                </div>
                <button type="button" onclick="login()" class="btn btn-login mt-4">ACCEDER</button>
            </form>
        </div>
    </div>

<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


<script type="text/javascript">
        // onkey Enter
        var input = document.getElementById("password");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                login();
            }
        });
        // inicio de sesion
        function login() {
            var usuario = document.getElementById('usuario').value;
            var password = document.getElementById('password').value;
            if(usuario === ''){
                toastr.error('Usuario es requerido');
                return;
            }
            if(password === ''){
                toastr.error('Contraseña es requerida');
                return;
            }
            openLoading();
            let formData = new FormData();
            formData.append('usuario', usuario);
            formData.append('password', password);
            axios.post('/admin/login', formData, {})
                .then((response) => {
                    closeLoading();
                    verificar(response);
                })
                .catch((error) => {
                    toastr.error('error al iniciar sesión');
                    closeLoading();
                });
        }
        // estados de la verificacion
        function verificar(response) {
            if (response.data.success === 0) {
                toastr.error('Validación incorrecta')
            } else if (response.data.success === 1) {
                window.location = response.data.ruta;
            } else if (response.data.success === 2) {
                toastr.error('Contraseña incorrecta');
            } else if (response.data.success === 3) {
                toastr.error('Usuario no encontrado')
            } else if (response.data.success === 5) {
                Swal.fire({
                    title: 'Usuario Bloqueado',
                    text: "Contactar a la administración",
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                }).then((result) => {});
            }
            else {
                toastr.error('Error al iniciar sesión');
            }
        }
    </script>
</body>

</html>
