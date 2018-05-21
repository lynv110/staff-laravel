<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="login">
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form action="" method="post">
                    {{ csrf_field() }}
                    <h1>{{ trans('common/common.text_change_pass') }}</h1>
                    <div>
                        <input type="password" class="form-control" name="password" placeholder="{{ trans('common/common.text_password_new') }}"/>
                        @if($errors->has('password'))
                            <p class="alert alert-danger">{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                    <div>
                        <input type="password" class="form-control" name="re_password" placeholder="{{ trans('common/common.text_password_new_2') }}"/>
                        @if($errors->has('re_password'))
                            <p class="alert alert-danger">{{ $errors->first('re_password') }}</p>
                        @endif
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary submit">{{ trans('common/common.button_change_pass') }}</button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
