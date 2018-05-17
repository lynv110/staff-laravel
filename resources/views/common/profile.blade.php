@extends('layout.master')
@section('heading_title', trans('common/profile.heading_title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ trans('common/profile.heading_title') }}</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ url('profile/edit') }}"><i class="fa fa-plus"></i> {{ trans('main.text_update') }}</a>
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
                        </div>
                        <div class="col-xs-12 col-sm-5">
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12 text-right" for="avatar">{{ trans('staff.text_avatar') }}</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    @if(is_file(config('image.path') . $info->avatar))
                                        <img src="{{ image_fit($info->avatar, 100, 100) }}" alt="" class="img-thumbnail">
                                    @else
                                        <img src="{{ no_image() }}" alt="" class="img-thumbnail">
                                    @endif
                                </div>
                            </div>
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