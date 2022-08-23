function goToQuestion(element) {
    element.addClass('active');
    $('html, body').animate({
        scrollTop: element.offset().top - $(window).height()/2 + element.height() / 2
    }, {duration: 100});
}

$(function () {
    var foundQuestion = false;
    $('.q-1of3:first-child').addClass('active');

    $('.q-1of3 input[type=\'radio\']').click(function () {
        var c = $(this).closest('.q-1of3');
        c.removeClass('active');
        goToQuestion(c.next());
    })

    // $('.q-1of3').each(function () {
    //     if ($(this).find("input[type='radio']:checked").length > 0) {
    //         return;
    //     }
    //     goToQuestion($(this));
    //     return false;
    // })
})

window.onbeforeunload = function() {
    return "Data will be lost if you leave the page, are you sure?";
};
