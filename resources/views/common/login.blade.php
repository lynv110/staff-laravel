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
</head>
<body class="login">
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form action="{{ url('login') }}" method="post">
                    {{ csrf_field() }}
                    <h1>{{ trans('login.btn_login') }}</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="text-left">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('flash_error'))
                        <div class="alert alert-danger">
                            <ul class="text-left">
                                <li>{{ session()->get('flash_error') }}</li>
                            </ul>
                        </div>
                    @endif

                    <div>
                        <input type="text" class="form-control" value="{{ old('username') }}" placeholder="{{ trans('login.text_username') }}" name="username"/>
                    </div>
                    <div>
                        <input type="password" class="form-control" name="password" placeholder="{{ trans('login.text_password') }}"/>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary submit">{{ trans('login.btn_login') }}</button>
                        <a class="reset_pass" href="#">Lost your password?</a>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
