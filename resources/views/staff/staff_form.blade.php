@extends('layout.master')
@section('heading_title', trans('staff.heading_title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $text_modified }}</h2>
                    <div class="pull-right">
                        @if($reset_pass)
                            <a class="btn btn-danger btn-sm" href="{{ url('staff/reset-password/' . $reset_pass) }}"><i class="fa fa-refresh"></i> {{ trans('main.text_reset_pass') }}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @endif
                        <a class="btn btn-primary btn-sm" onclick="$('#form').attr('action', '{{ $action }}'); $('input[name=\'_redirect\']').val('add'); $('#form').submit();"><i class="fa fa-plus"></i> {{ trans('main.text_save_add') }}</a>
                        <a class="btn btn-primary btn-sm" onclick="$('#form').attr('action', '{{ $action }}'); $('input[name=\'_redirect\']').val('edit'); $('#form').submit();"><i class="fa fa-plus"></i> {{ trans('main.text_save_edit') }}</a>
                        <a class="btn btn-primary btn-sm" onclick="$('#form').attr('action', '{{ $action }}'); $('input[name=\'_redirect\']').val('exit'); $('#form').submit();"><i class="fa fa-plus"></i> {{ trans('main.text_save_exit') }}</a>
                        <a class="btn btn-warning btn-sm" href="{{ $cancel }}"><i class="fa fa-times"></i> {{ trans('main.text_cancel') }}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <form id="form" action="" class="form-horizontal form-label-left" method="post">
                        <input type="hidden" name="_redirect" value="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('staff.text_name') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{ $name }}">
                                @if($errors->has('name'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">{{ trans('staff.text_telephone') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="telephone" class="form-control col-md-7 col-xs-12" name="telephone" value="{{ $telephone }}">
                                @if($errors->has('telephone'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('telephone') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">{{ trans('staff.text_address') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="address" cols="30" rows="2" class="form-control col-md-7 col-xs-12">{{ $address }}</textarea>
                                @if($errors->has('address'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('address') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('staff.text_gender') }}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="gender" id="gender" class="form-control col-md-7 col-xs-12" >
                                    <option value="0" @if($gender == '0') selected @endif>{{ trans('staff.text_male') }}</option>
                                    <option value="1" @if($gender == '1') selected @endif>{{ trans('staff.text_female') }}</option>
                                    <option value="2" @if($gender == '2') selected @endif>{{ trans('staff.text_other') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('staff.text_email') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="email" class="form-control col-md-7 col-xs-12" name="email" value="{{ $email }}">
                                @if($errors->has('email'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="birthday">{{ trans('staff.text_birthday') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class='input-group date' id='myDatepicker2'>
                                    <input type="text" id="birthday" placeholder="yyyy-mm-dd" class="form-control col-md-7 col-xs-12" name="birthday" value="{{ $birthday }}">
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="avatar">{{ trans('staff.text_avatar') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" name="avatar" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">{{ trans('staff.text_username') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="username" class="form-control col-md-7 col-xs-12" name="username" value="{{ $username }}">
                                @if($errors->has('username'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('username') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">{{ trans('staff.text_password') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class='input-group'>
                                    <input type="text" id="password" class="form-control col-md-7 col-xs-12 pull-left" name="password" value="{{ $password }}">
                                    <span class="input-group-addon" style="padding: 0">
                                       <button type="button" class="btn btn-primary btn-xs password-random">{{ trans('staff.text_random') }}</button>
                                    </span>
                                </div>
                                @if($errors->has('password'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="part">{{ trans('staff.text_part') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="part[]" id="part" class="form-control col-md-7 col-xs-12 select-multiple" multiple="multiple">
                                    @foreach($parts as $pt)
                                    <option @if(in_array($pt->id, $part)) selected @endif value="{{ $pt->id }}">{{ $pt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="position">{{ trans('staff.text_position') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="position[]" id="position" class="form-control col-md-7 col-xs-12 select-multiple" multiple="multiple">
                                    @foreach($positions as $pos)
                                        <option @if(in_array($pos->id, $position)) selected @endif value="{{ $pos->id }}">{{ $pos->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('main.text_status') }}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="status" id="status" class="form-control col-md-7 col-xs-12" >
                                    @if($status)
                                        <option value="0">{{ trans('main.text_disabled') }}</option>
                                        <option value="1" selected>{{ trans('main.text_enabled') }}</option>
                                    @else
                                        <option value="0" selected>{{ trans('main.text_disabled') }}</option>
                                        <option value="1">{{ trans('main.text_enabled') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_footer')
    <script>
        $('.select-multiple').select2();
        $('#birthday').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('.password-random').on('click', function (e) {
            e.preventDefault();
            $(this).parent().parent().find('input').val(makeid(15));
        })

        function makeid(length) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < length; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }
    </script>
@endpush