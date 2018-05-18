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
@endif
@endsection