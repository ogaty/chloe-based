$(function() {
    /*
     *  Scroll To Top
     */
    if ($('#scroll-to-top')[0] && $('#top-link-block')[0]) {
        $('#scroll-to-top').click(function () {
            $('html,body').animate({scrollTop: 0}, 'slow');
            return false;
        });

        if (($(window).height() + 100) < $(document).height()) {
            $('#top-link-block').removeClass('hidden');
        }
    }

    $(window).scroll(function() {
    if ($(window).scrollTop() > 100) {
        if ($('#top-link-block').hasClass('affix-top')) {
            $('#top-link-block').removeClass('affix-top').addClass('affix');
        }
    } else if ($(window).scrollTop() == 0) {
        if ($('#top-link-block').hasClass('affix')) {
            $('#top-link-block').removeClass('affix').addClass('affix-top');
        }
    }
    });
});
