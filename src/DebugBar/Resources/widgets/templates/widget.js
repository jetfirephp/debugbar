(function($) {

    var csscls = PhpDebugBar.utils.makecsscls('phpdebugbar-widgets-');

    /**
     * Widget for the displaying templates data
     *
     * Options:
     *  - data
     */
    var TemplatesWidget = PhpDebugBar.Widgets.TemplatesWidget = PhpDebugBar.Widget.extend({

        className: csscls('templates'),

        render: function() {
            this.$dom = $('<div />').appendTo(this.$el);

            this.bindAttr('data', function(data) {
                this.$dom.empty();
                $('<div />').html(data).appendTo(this.$dom);
            });
        }

    });

})(PhpDebugBar.$);
