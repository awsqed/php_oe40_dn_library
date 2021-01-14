$('.like-button').on('click', '.btn-like', {}, function () {
    window.axios.post('/book/'+ $(this).val() +'/like')
                .then(function (response) {
                    $('.like-button').html(response.data.likeButton);
                    $('.like-count').html(response.data.likeCount);
                });
});

$('.fl-button').on('click', '.btn-follow', {}, function () {
    window.axios.post('/'+ $(this).attr('followable-type') +'/'+ $(this).val() +'/follow')
                .then(function (response) {
                    $('.fl-button').html(response.data);
                });
});
