@extends('layout.master')
@section('heading_title', 'Dashboard page')
@section('content')

@if(Staff::isRoot())
<div class="row">
    <div class="col-md-4">
        <div class="row top_tiles">
            <div class="animated flipInY col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                    <div class="count">{{ $total_staff }}</div>
                    <h3>{{ trans('common/dashboard.text_staff') }}</h3>
                </div>
            </div>
            <div class="animated flipInY col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-comments-o"></i></div>
                    <div class="count">{{ $total_part }}</div>
                    <h3>{{ trans('common/dashboard.text_part') }}</h3>
                </div>
            </div>
            <div class="animated flipInY col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                    <div class="count">{{ $total_position }}</div>
                    <h3>{{ trans('common/dashboard.text_position') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ trans('common/dashboard.text_logged_latest') }}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach($latests as $latest)
                <article class="media event">
                    <div class="media-body">
                        <a class="title" href="{{ url('staff/info/' . $latest->id) }}">{{ $latest->name }}</a>
                        <p>{{ datetime_to_list($latest->login_at) }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>

</div>
@else
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ trans('common/dashboard.text_welcome') . ' ' . Staff::getName() }}</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <h4>{{ trans('common/dashboard.text_information') }}</h4>
            <div class="form-group row">
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_name') }}</label>
                <div class="col-sm-10 col-xs-12">
                    {{ $info->name }}
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_telephone') }}</label>
                <div class="col-sm-10 col-xs-12">
                    {{ $info->telephone }}
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_address') }}</label>
                <div class="col-sm-10 col-xs-12">
                    {{ $info->address }}
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_gender') }}</label>
                <div class="col-sm-10 col-xs-12">
                    @if($info->gender == '0')
                        {{ trans('staff.text_male') }}
                    @elseif($info->gender == '1')
                        {{ trans('staff.text_female') }}
                    @else
                        {{ trans('staff.text_other') }}
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_birthday') }}</label>
                <div class="col-sm-10 col-xs-12">
                    {{ $info->birthday }}
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_part') }}</label>
                <div class="col-sm-10 col-xs-12">
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
                <label class="control-label col-sm-2 col-xs-12 " for="name">{{ trans('staff.text_position') }}</label>
                <div class="col-sm-10 col-xs-12">
                    @if($positions)
                        <ul>
                            @foreach($positions as $position)
                                <li>{{ $position }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
@endsection