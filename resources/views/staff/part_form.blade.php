@extends('layout.master')
@section('heading_title', trans('part.heading_title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $text_modified }}</h2>
                    <div class="pull-right">
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('part.text_name') }}
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sort_order">{{ trans('main.text_sort_order') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="sort_order" name="sort_order" value="{{ $sort_order }}" class="form-control col-md-7 col-xs-12">
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