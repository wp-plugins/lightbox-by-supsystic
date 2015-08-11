(function($) {

    var Controller = function() {
        this.$btnSave = $('#lbsSaveSettings');
        this.$container = $('#containerWrapper');
        this.$pagesTable= $('#jq-post-pages-table');
        this.$pagesDialog = $('.posts-and-pages-dialog');
    };

    Controller.prototype.saveSettings = function() {
        var self = this;

        this.$btnSave.on('click', function() {
            $('#lbsSettingsForm').sendFormLbs({
                btn: self.$btnSave,
                onSuccess: function(response) {

                    self.$btnSave.find('i').removeClass('fa-spinner')
                        .removeClass('fa-spin')
                        .addClass('fa-save');
                }
            });
            return false;
        });
    };

    Controller.prototype.checkboxHelper = function() {
        var $radioButtons = this.$container.find('[type="radio"]');

        $radioButtons.on('click', function() {
            $radioButtons.filter('[data-type="' + $(this).data('type') + '"]').iCheck('uncheck');
            $(this).iCheck('check');
        });
    };

    Controller.prototype.initPagesTable = function() {
        this.$pagesTable.jqGrid({
            datatype: "local",
            autowidth: true
            , shrinkToFit: true
            , colNames: ['ID']
            , colModel: [
                {name: 'id', index: 'id' , sortable: false, align: 'center'}
                //, {name: 'title', index: 'title' , sortable: false, align: 'center'}
            ]
            , caption: 'Pages'
            , height: '100%'
            , emptyrecords: 'You have no data for now.'
            , multiselect: true
        });
    };

    Controller.prototype.initLocationAdding = function() {
        var $buttons = $('#add-post, #add-page');

        $buttons.on('click', function(e) {
            e.preventDefault();

            $.sendFormLbs({
                data: {mod: 'lightbox', action: 'addPageAction', pageId: $('.' + $(this).attr('id') + '-list').val() }
                ,	onSuccess: function(response) {
                    if(response['data']['status']) {
                        console.log('Successfully added');
                        location.reload();
                    } else {
                        console.log('Already added');
                    }
                }
            });
        });
    };

    Controller.prototype.fillPagesTable = function() {
        var self = this;
        $.sendFormLbs({
            data: {mod: 'lightbox', action: 'getPagesAction'}
            ,	onSuccess: function(response) {
                if(response.data.pages && response.data.pages.length) {
                    $.each(response.data.pages, function(index, value) {
                        self.$pagesTable.jqGrid('addRowData', index, { id: value });
                    });
                } else {
                    //show empty table message
                }
            }
        });
    };

    Controller.prototype.initPagesDialog = function() {
        var $button = $('#open-pages-dialog'),
            self = this;

        this.$pagesDialog.dialog({
            autoOpen: false,
            modal:    true,
            width:    600
        });

        $button.on('click', function(e) {
            e.preventDefault();

            self.$pagesDialog.dialog('open');
        })
    };

    Controller.prototype.togglePagesDialogButton = function() {
        var $button = $('#open-pages-dialog');

        this.$container.find('input[type="radio"]').on('click', function() {
            if($(this).attr('name') == 'general[page]') {
                $button.show();
            } else {
                $button.hide();
            }
        });
    };


    Controller.prototype.init = function() {
        this.saveSettings();
        this.checkboxHelper();
        this.initPagesTable();
        this.initLocationAdding();
        this.fillPagesTable();
        this.initPagesDialog();
        //this.togglePagesDialogButton();
    };

    $(document).ready(function() {
        var controller = new Controller();

        controller.init();
    });

})(jQuery);