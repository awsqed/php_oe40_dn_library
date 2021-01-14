$('.btn-rate').click(function () {
    window.axios.post('/book/'+ $(this).val() +'/rate', {
        rating: $('#input-rating').val(),
        comment: $('#input-comment').val()
    }).then(function (response) {
        $('.review-list').html(response.data.reviewList);
        $('.avg-rating').html(response.data.avgRating);
        $('.review-count').html(response.data.reviewCount);
        $('.review-form').remove();
    });
});
