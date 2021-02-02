$(document).ready(function () {
    window.axios.get('/notifications/channel')
                .then(function (response) {
                    if (response.data) {
                        window.Echo.private(response.data)
                                    .notification((notification) => {
                                        var isDashboard = window.location.href.search('laravel.site/dashboard') !== -1;
                                        window.axios.get('/notifications/unread?view='+ (isDashboard ? 'dashboard' : 'home'))
                                                    .then(function (response) {
                                                        var node = $('.notification');

                                                        var isOpen = node.hasClass('show');
                                                        node.html(response.data);
                                                        if (isOpen) {
                                                            node.find('a.dropdown').dropdown('show');
                                                        }
                                                    });
                                    });

                        $('.notification').on('click', '.notification-link', {}, function (e) {
                            e.preventDefault();

                            var href = $(this).attr('href');
                            window.axios.get('/notifications/mark-as-read/'+ $(this).attr('notification-id'))
                                        .then(function (response) {
                                            window.location.href = href;
                                        });
                        });
                    }
                });
});
