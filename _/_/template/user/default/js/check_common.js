$(function() {
    $('.help').live('hover', function(e) {
        if (event.type == 'mouseover') {
            $(this).next('.js-intro-popover').show();
        } else if (event.type == 'mouseout') {
            $(this).next('.js-intro-popover').hide();
        }
    });
})

