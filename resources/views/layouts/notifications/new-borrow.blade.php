<a href="" class="badge badge-success mr-2 font-weight-bold text-uppercase badge-accept" borrow-id="{{ $notification->data['borrow-id'] }}">
    <i class="fas fa-check"></i>
    {{ trans('borrows.accept') }}
</a>
<a href="" class="badge badge-danger font-weight-bold text-uppercase badge-reject" borrow-id="{{ $notification->data['borrow-id'] }}">
    <i class="fas fa-times"></i>
    {{ trans('borrows.reject') }}
</a>
<br>
