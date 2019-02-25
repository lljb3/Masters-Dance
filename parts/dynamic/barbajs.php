<script type="text/javascript" id="barba-script">
    (function ($, window, document) {
        // BarbaJS
        var FadeTransition = Barba.BaseTransition.extend({
            start: function() {
                Promise
                .all([this.newContainerLoading, this.fadeOut()])
                .then(this.fadeIn.bind(this));
            },
            fadeOut: function() {
                return $(this.oldContainer).animate({ opacity: 0 }).promise();
            },
            fadeIn: function() {
                var _this = this;
                var $el = $(this.newContainer);
                $(this.oldContainer).hide();
                $el.css({
                    visibility : 'visible',
                    opacity : 0
                });
                $el.animate({ opacity: 1 }, 400, function() {
                    _this.done();
                });
            },
        });
        Barba.Pjax.getTransition = function() {
            return FadeTransition;
        };
        Barba.Dispatcher.on('linkClicked', function(oldContainer) {
            setTimeout(killSlider);
        });
        Barba.Dispatcher.on('transitionCompleted', function(newContainer) {
            setTimeout(startSlider);
        });
        var BarbaContainer = Barba.BaseView.extend({
            namespace: 'barba-container',
            onLeave: function() {
                // A new Transition toward a new page has just started.
            },
            onLeaveCompleted: function() {
                // The Container has just been removed from the DOM.
            },
            onEnter: function() {
                // The new Container is ready and attached to the DOM.
                setHeight();
                stickyHeader();
                navbarTrans();
                navbarDropdown();
                flowtypeJS();
                toTop();
            },
            onEnterCompleted: function() {
                // The Transition has just finished.
                externalLinkage();
                FacebookAPI();
                twitterAPI();
            },
        });
        BarbaContainer.init();
        Barba.Pjax.start();
        Barba.Prefetch.init();
    })(jQuery, window, document);
</script>