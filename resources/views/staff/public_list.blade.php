@extends('layout.master')
@section('heading_title', trans('staff.heading_title'))
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ trans('main.text_list') }}</h2>
                    <div class="pull-right">

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="form" action="" class="form-horizontal form-label-left" method="post">
                        {{ csrf_field() }}
                        <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="flat check-all"></th>
                                <th>{{ trans('staff.text_name') }}</th>
                                <th style="width: 110px;" class="text-right">{{ trans('main.text_action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td><input type="text" class="form-control" value="{{ $filter_name }}" name="filter_name"></td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-primary filter">{{ trans('main.text_filter') }}</a>
                                </td>
                            </tr>
                            @if($staffs)
                                @foreach($staffs as $staff)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="{{ $staff['id'] }}" name="id[]" class="flat check">
                                        </td>
                                        <td>{{ $staff['name'] }}</td>
                                        <td class="text-right">
                                            @if($staff['info'])
                                                <a href="{{ url('staff/info/' . $staff['id']) }}" class="btn btn-sm btn-success">{{ trans('main.text_info') }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
                                        {{ trans('main.text_no_result') }}
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div>
                            {{ $staffs->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_footer')
    <script>
        $('.filter').bind('click', function (e) {
            e.preventDefault();
            href = '{{ url('staff') }}?filter';
            filter_name = $('input[name="filter_name"]').val();
            filter_telephone = $('input[name="filter_telephone"]').val();
            filter_email = $('input[name="filter_email"]').val();
            filter_status = $('select[name="filter_status"]').find('option:selected').val();
            filter = false;
            if (filter_name !== ''){
                href += '&filter_name=' + filter_name;
                filter = true;
            }
            if (filter_email !== ''){
                href += '&filter_email=' + filter_email;
                filter = true;
            }
            if (filter_telephone !== ''){
                href += '&filter_telephone=' + filter_telephone;
                filter = true;
            }
            if (filter_status !== ''){
                href += '&filter_status=' + filter_status;
                filter = true;
            }
            if (filter === true){
                location = href;
            }else{
                location = '{{ url('staff') }}';
            }
        })
    </script>
@endpush