<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Xantore
    </title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Webclub.UZ" />

    <!-- Favicon icon -->
    <link rel="icon" href="/admin/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="/admin/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="/admin/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="/admin/css/style.css">
    <style>
        .cursor-pointer{
            cursor: pointer;
        }
    </style>
</head>

    <form class="auth-wrapper" method="POST" action="{{ route('auth.login') }}">
        @csrf
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                        </div>
                    @endif

                    <h3 class="mb-4">Авторизация</h3>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Имя пользователя или телефон номер" name="user" id="Логин"
                            autofocus value="{{ old('user') }}" required>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control" placeholder="Пароль" name="password" id="password" required><span id="toggle-password"
                        class="fa fa-fw fa-eye-slash pass-icon cursor-pointer d-flex align-items-center"></span>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4" id="save">
                        Войти
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Required Js -->
    <script src="/admin/js/vendor-all.min.js"></script>
    <script src="/admin/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $("form").submit(function () {
        $("#save").attr("disabled", true);
        });
    </script>

    <script>
        $(document).on('click', '#toggle-password', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });
    </script>
</body>

</html>
