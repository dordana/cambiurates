function is_touch_device() {
    return !!('ontouchstart' in window);
}

$(function() {
    $(document).foundation();

    if (!is_touch_device()) {
        $('.scrollbar').slimScroll({
            alwaysVisible: false,
            railVisible: false,
            height: 'auto',
            opacity: 0
        }).mouseover(function () {
            $(this).next('.slimScrollBar').css('opacity', 0.4);
        });
    }
});