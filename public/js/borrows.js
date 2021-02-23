$('.borrow-table').on('click', '.btn-accept', {}, function () {
    updateBorrowRequest($(this).val(), 'accept');
});

$('.borrow-table').on('click', '.btn-reject', {}, function () {
    updateBorrowRequest($(this).val(), 'reject');
});

$('.borrow-table').on('click', '.btn-return', {}, function () {
    updateBorrowRequest($(this).val(), 'return');
});

$('.delete-borrow').click(function (e) {
    e.preventDefault();

    window.axios.delete('/dashboard/borrows/'+ $(this).attr('borrow-id'))
                .then(function () {
                    window.location.reload();
                });
});

function updateBorrowRequest(borrowRequestId, action)
{
    window.axios.put('/dashboard/borrows/'+ borrowRequestId, {
        action: action,
        search: $('input[name=search]').val(),
        filter: $('select[name=filter] option:checked').val()
    }).then(function (response) {
        $('.borrow-table').html(response.data);
    });
}
