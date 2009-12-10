(function($) {
    $.fn.wait = function(option, options) {
        milli = 1000;
        if (option && (typeof option == 'function' || isNaN(option)) ) {
            options = option;
        } else if (option) {
            milli = option;
        }
        // set defaults
        var defaults = {
            msec: milli,
            onEnd: options
        },
        settings = $.extend({},defaults, options);

        if(typeof settings.onEnd == 'function') {
            this.each(function() {
                setTimeout(settings.onEnd, settings.msec);
            });
            return this;
        } else {
            return this.queue('fx',
                function() {
                    var self = this;
                    setTimeout(function() {
                        $.dequeue(self);
                    },settings.msec);
                });
        }

    }
})(jQuery);