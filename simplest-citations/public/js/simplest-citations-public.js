(function($) {
    'use strict';

    $(document).ready(function() {
        const citeLinks = $('.cite-tooltip');

        citeLinks.each(function() {
            $(this).on('mouseenter', function() {
                const tooltip = $(this).data('tooltip');
                $(this).attr('title', tooltip);
            });

            $(this).on('mouseleave', function() {
                $(this).removeAttr('title');
            });
        });
    });

})(jQuery);
