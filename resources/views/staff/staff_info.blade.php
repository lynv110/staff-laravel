@extends('layout.master')
@section('heading_title', trans('staff.heading_title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $text_modified }}</h2>
                    <div class="pull-right">
                        <a class="btn btn-danger btn-sm" href="{{ url('staff/reset-password/' . $info->id) }}"><i class="fa fa-refresh"></i> {{ trans('main.text_reset_pass') }}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-primary btn-sm" href="{{ url('staff/edit/' . $info->id) }}"><i class="fa fa-plus"></i> {{ trans('main.text_edit') }}</a>
                        <a class="btn btn-warning btn-sm" href="{{ $cancel }}"><i class="fa fa-times"></i> {{ trans('main.text_cancel') }}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-7">
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_name') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->name }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_telephone') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->telephone }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_address') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->address }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_gender') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    @if($info->gender == '0') {{ trans('staff.text_male') }} @endif
                                    @if($info->gender == '1') {{ trans('staff.text_female') }} @endif
                                    @if($info->gender == '2') {{ trans('staff.text_other') }} @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_birthday') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->birthday }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_created_at') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->created_at }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_modified_at') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->modified_at }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="name">{{ trans('staff.text_login_at') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{ $info->login_at }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 text-right" for="name">{{ trans('staff.text_email') }}</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    {{ $info->email }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 text-right" for="name">{{ trans('staff.text_username') }}</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    {{ $info->username }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 text-right" for="name">{{ trans('staff.text_part') }}</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    @if($parts)
                                        <ul>
                                        @foreach($parts as $part)
                                            <li>{{ $part }}</li>
                                        @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 text-right" for="name">{{ trans('staff.text_position') }}</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    @if($positions)
                                        <ul>
                                            @foreach($positions as $position)
                                                <li>{{ $position }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 text-right" for="name">{{ trans('main.text_status') }}</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    @if($info->status)
                                        {{ trans('main.text_enabled') }}
                                    @else
                                        {{ trans('main.text_disabled') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
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
    </script>
@endpush