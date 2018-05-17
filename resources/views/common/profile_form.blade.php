@extends('layout.master')
@section('heading_title', trans('staff.heading_title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $text_modified }}</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" onclick="$('#form').attr('action', '{{ $action }}'); $('input[name=\'_redirect\']').val('edit'); $('#form').submit();"><i class="fa fa-plus"></i> {{ trans('main.text_save_edit') }}
                        </a>
                        <a class="btn btn-primary btn-sm" onclick="$('#form').attr('action', '{{ $action }}'); $('input[name=\'_redirect\']').val('exit'); $('#form').submit();"><i class="fa fa-plus"></i> {{ trans('main.text_save_exit') }}
                        </a>
                        <a class="btn btn-warning btn-sm" href="{{ $cancel }}"><i class="fa fa-times"></i> {{ trans('main.text_cancel') }}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <form id="form" action="" class="form-horizontal form-label-left" method="post">
                        <input type="hidden" name="_redirect" value="">
                        <input type="hidden" name="id" value="{{ Staff::getId() }}">
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
                                <select name="gender" id="gender" class="form-control col-md-7 col-xs-12">
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
                                <div class="image">
                                    <img src="{{ $thumb }}" alt="avatar" class="img-thumbnail img-responsive">
                                    <button type="button" class="btn btn-primary btn-xs button-upload">{{ trans('main.text_select_image') }}</button>
                                    <button type="button" class="btn btn-danger btn-xs button-delete">{{ trans('main.text_delete_image') }}</button>
                                    <input type="hidden" name="avatar" value="" id="avatar">
                                </div>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">{{ trans('staff.text_password') }}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class='input-group'>
                                    <input type="password" id="password" class="form-control col-md-7 col-xs-12 pull-left" name="password" value="{{ $password }}">
                                    <span class="input-group-addon" style="padding: 0">
                                       <button type="button" class="btn btn-primary btn-xs password-info">{{ trans('main.text_info') }}</button>
                                    </span>
                                </div>
                                @if($errors->has('password'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password2">{{ trans('staff.text_re_password') }}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class='input-group'>
                                    <input type="password" id="password2" class="form-control col-md-7 col-xs-12 pull-left" name="password2" value="{{ $password2 }}">
                                    <span class="input-group-addon" style="padding: 0">
                                       <button type="button" class="btn btn-primary btn-xs password-info">{{ trans('main.text_info') }}</button>
                                    </span>
                                </div>
                                @if($errors->has('password2'))
                                    <div class="clearfix"></div>
                                    <p class="alert alert-danger">{{ $errors->first('password2') }}</p>
                                @endif
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

        $('form').delegate('.password-info', 'click', function (e) {
            var _input  = $(this).parent().parent().find('input');
            var _this = $(this);
            if (_input.attr('type') === 'text') {
                _this.html('{{ trans('main.text_hidden') }}');
                _input.attr('type', 'password');
            } else {
                _this.html('{{ trans('main.text_info') }}');
                _input.attr('type', 'text');
            }
        });
    </script>

    <script>
        $('button.button-delete').on('click', function (e) {
            e.preventDefault();
            $(this).next('input').val('');
            $(this).parent().find('img').attr('src', '{{ no_image() }}');
        });

        $('button.button-upload').on('click', function (e) {
            var _this = $(this);
            $('#form-upload').remove();
            html = '<form style="display: none;" id="form-upload" enctype="multipart/form-data">';
            html += '<input type="file" name="file" value="" id="fileToUpload">';
            html += '</form>';

            $('body').prepend(html);
            $('#form-upload input[name=\'file\']').trigger('click');

            if (typeof timer != 'undefined') {
                clearInterval(timer);
            }

            timer = setInterval(function () {
                if ($('#form-upload input[name=\'file\']').val() != '') {
                    clearInterval(timer);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ url('upload-file') }}',
                        type: 'post',
                        dataType: 'json',
                        data: new FormData($('#form-upload')[0]),
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('.button-upload').prop('disabled', true);
                        },
                        complete: function () {
                            $('.button-upload').prop('disabled', false);
                        },
                        success: function (json) {
                            if (json['error']) {
                                alert(json['error']);
                            }

                            if (json['success']) {
                                alert(json['success']);
                                if (json['info']) {
                                    _this.parent().find('img').attr('src', json['info']['thumb']);
                                    _this.parent().find('input').val(json['info']['filename']);
                                }
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            }, 500);
        })
    </script>
@endpush