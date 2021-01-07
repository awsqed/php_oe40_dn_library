{{-- TODO: Permission Check --}}
<x-dashboard title="{{ trans('dashboard.admin-panel') }}">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('dashboard') }}
    </x-slot>
</x-dashboard>
