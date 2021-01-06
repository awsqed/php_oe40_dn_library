{{-- TODO: Permission Check --}}
<x-dashboard title="{{ trans('dashboard.admin-panel') }}">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('permissions.edit', $permission) }}
    </x-slot>

    <div class="card">
        <h5 class="card-header">
            <i class="fas fa-edit fa-fw"></i>
            <strong>{{ trans('permissions.editing') }}:</strong>
            <i class="user-select-all">{{ $permission->name }}</i>
        </h5>
        <div class="card-body">
            <div class="col-4 float-left">
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-2 mb-3">
                        <div class="col-3">
                            <label for="input-id" class="col-form-label">ID</label>
                        </div>
                        <div class="col-2">
                            <input type="number" id="input-id" class="form-control" value="{{ $permission->id }}" disabled>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-3">
                            <label for="input-desc" class="col-form-label">{{ trans('permissions.description') }}</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="input-desc" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') ?? $permission->description }}" placeholder="{{ trans('permissions.input-desc-placeholder') }}" maxlength="254">
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-3"></div>
                        <div class="col-9">
                            <button class="btn btn-primary" type="submit">{{ trans('permissions.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            @if (count($childs) > 0)
                <div class="card col-3 float-right h-50">
                    <h6 class="card-header font-weight-bold">
                        {{ trans('permissions.childrens') }} ({{ count($childs) }})
                    </h6>
                    <ul class="list-group list-group-flush scrollable-150">
                        @foreach ($childs as $child)
                            <li class="list-group-item user-select-all">
                                {{ $child }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="clear-fix"></div>
        </div>
    </div>

</x-dashboard>
