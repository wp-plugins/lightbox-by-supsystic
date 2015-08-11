(function($) {

    var Controller = function(initialSettings) {
        this.settings = initialSettings;
        this.$container = $('.entry-content');
    };

    Controller.prototype.initializeFancybox = function() {
        var self = this;

        this.$container.find('img').not('.supsystic-special-image').each(function() {
            $(this).parent().addClass('supsystic-fancybox');
            if(self.settings.gallery) {
                $(this).parent().attr('rel', 'supsystic-set');
            }
            $(this).parent().attr('title', $(this).attr('alt'));
        });

        this.prepareSettings();

        this.$container.find('.supsystic-fancybox').fancybox(this.settings);

        this.$container.find('a.lbs-video').each(function() {
            this.href = this.href.replace(new RegExp("watch\\?v=", "i"), 'v/');
        });
        this.$container.find('a.lbs-video').fancybox({
            'type'      : 'swf',
            'swf'       : {'wmode':'transparent','allowfullscreen':'true'}
        });
    };

    Controller.prototype.prepareSettings = function() {
        var self = this;

        $.each(this.settings, function(index, value) {
            if(value == 'on') {
                self.settings[index] = true;
            }

            if(value == parseInt(value, 10)) {
                self.settings[index] = parseInt(value);
            }
        });

        this.settings['closeBtn'] = this.settings['closeBtn'] ? this.settings['closeBtn'] : false;

        if(this.settings['helpers'] && this.settings['helpers']['thumbs']) {
            this.settings['helpers']['thumbs'] = {
                width: 50,
                height: 50
            }
        }

        this.settings['helpers']['title'] = this.settings['helpers']['title']['type'] != 'null' ? this.settings['helpers']['title'] : null;
    };

    Controller.prototype.init = function() {
        this.initializeFancybox();
    };

    $(document).ready(function() {
        var controller = new Controller(lbsSettings);

        controller.init();
    });

})(jQuery);