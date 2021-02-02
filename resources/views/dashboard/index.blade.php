<x-dashboard>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('dashboard') }}
    </x-slot>

    @can('read-borrow-request')
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header h5">
                        {{ trans('dashboard.charts.daily') }} ({{ $date }})
                    </div>

                    <div class="card-body">
                        <div id="dailyBorrowsChart" class="chart"></div>
                    </div>

                    <div class="card-footer mb-0 text-center text-uppercase h5">
                        <strong>{{ $todayCount }}</strong>
                        <br>
                        <small>{{ trans('dashboard.charts.total-requests') }}</small>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header h5">
                        {{ trans('dashboard.charts.monthly') }} ({{ $month }})
                    </div>

                    <div class="card-body">
                        <div id="monthlyBorrowsChart" class="chart"></div>
                    </div>

                    <div class="card-footer mb-0 text-center text-uppercase h5">
                        <strong>{{ $monthlyCount }}</strong>
                        <br>
                        <small>{{ trans('dashboard.charts.total-requests') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header h5">
                {{ trans('dashboard.charts.yearly') }} ({{ $year }})
            </div>

            <div class="card-body">
                <div id="yearlyBorrowsChart" class="chart"></div>
            </div>

            <div class="card-footer mb-0 text-center text-uppercase h5">
                <strong>{{ $yearlyCount }}</strong>
                <br>
                <small>{{ trans('dashboard.charts.total-requests') }}</small>
            </div>
        </div>
    @endcan

    @push('page_scripts')
        <script src="{{ asset('js/Chart.min.js') }}"></script>
        <script src="{{ asset('js/chartisan_chartjs.umd.js') }}"></script>
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-dashboard>
