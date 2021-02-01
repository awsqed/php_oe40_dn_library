const dailyChart = new Chartisan({
    el: '#dailyBorrowsChart',
    url: 'http://laravel.site/api/chart/daily_borrows_chart',
    hooks: new ChartisanHooks()
                .colors()
                .responsive()
                .stepSize(1),
});

const monthlyChart = new Chartisan({
    el: '#monthlyBorrowsChart',
    url: 'http://laravel.site/api/chart/monthly_borrows_chart',
    hooks: new ChartisanHooks()
                .colors()
                .responsive()
                .stepSize(2),
});

const yearlyChart = new Chartisan({
    el: '#yearlyBorrowsChart',
    url: 'http://laravel.site/api/chart/yearly_borrows_chart',
    hooks: new ChartisanHooks()
                .datasets([{
                    type: 'line',
                    fill: false,
                    borderColor: '#667EEA'
                }])
                .colors()
                .responsive()
                .stepSize(10),
});
