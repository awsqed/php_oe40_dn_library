@props([
    'data',
])

<div class="float-left">
    {{ trans('general.result-count', [
        'from' => $data->firstItem(),
        'to' => $data->firstItem() + $data->count() - 1,
    ]) }}
</div>
<div class="float-right">
    {{ $data->links('vendor.pagination.bootstrap-4') }}
</div>
<div class="clearfix"></div>
