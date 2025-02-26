(function ($) {
    "use strict";
	$(document).ready(function() {
        if( $(".side-navigation-content").length ) {
            $('.side-navigation')
                .theiaStickySidebar({
                    additionalMarginTop: 90,
                    containerSelector: $('.side-navigation-content')
                });
        }
    });
})(jQuery);