function goToQuestion(element) {
    element.addClass('active');
    $('html, body').animate({
        scrollTop: element.offset().top - $(window).height()/2 + element.height() / 2
    }, {duration: 100});
}

$(function () {
    $('.q-scale:first-child').addClass('active');

    $('.q-scale input[type=\'radio\']').click(function () {
        var c = $(this).closest('.q-scale');
        c.removeClass('active');
        goToQuestion(c.next());
    })

    $('.test-section input[type=\'radio\']').click(function () {
        $('.test-section:not(.active)').addClass('active');
    });
})
