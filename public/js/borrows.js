$('.borrow-table').on('click', '.btn-accept', {}, function () {
    var brId = $(this).val();
    window.axios.post('/dashboard/borrows/'+ brId +'/accept', {
        'search': $('input[name=search]').val(),
        'filter': $('select[name=filter] option:checked').val()
    }).then(function (response) {
        $('.borrow-table').html(response.data);
    });
});

$('.borrow-table').on('click', '.btn-reject', {}, function () {
    var brId = $(this).val();
    window.axios.post('/dashboard/borrows/'+ brId +'/reject', {
        'search': $('input[name=search]').val(),
        'filter': $('select[name=filter] option:checked').val()
    }).then(function (response) {
        $('.borrow-table').html(response.data);
    });
});

$('.borrow-table').on('click', '.btn-return', {}, function () {
    var brId = $(this).val();
    window.axios.post('/dashboard/borrows/'+ brId +'/return', {
        'search': $('input[name=search]').val(),
        'filter': $('select[name=filter] option:checked').val()
    }).then(function (response) {
        $('.borrow-table').html(response.data);
    });
});
