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
                <form action="{{ url('forgot-password') }}" method="post">
                    {{ csrf_field() }}
                    <h1>{{ trans('common/forgot.text_heading') }}</h1>

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

                    @if(session()->has('flash_success'))
                        <div class="alert alert-success">
                            <ul class="text-left">
                                <li>{{ session()->get('flash_success') }}</li>
                            </ul>
                        </div>
                    @endif

                    <div>
                        <input type="email" class="form-control" value="{{ old('email') }}" placeholder="{{ trans('common/forgot.text_email') }}" name="email"/>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary submit">{{ trans('common/forgot.btn_forgot') }}</button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
