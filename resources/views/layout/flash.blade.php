@if(session()->has('flash_notification.message'))
    <div class="alert alert-{{ session()->get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><i class="fa fa-{{ session()->get('flash_notification.icon') }}"></i></strong> {{ session()->get('flash_notification.message') }}
    </div>
@endif