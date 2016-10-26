/**
 * Primary Modal Application Class
 */
Generate_Sections.backbone_modal.Application = Backbone.View.extend({

    attributes: {
        id: "generate-sections-modal-dialog",
        class: "generate-sections-modal",
        role: "dialog"
    },

    template: wp.template("generate-sections-modal-window"),

    mediaUploader: null,

    /*-----------------------------------------------------------------------------------*/
    /* tinyMCE settings
    /*-----------------------------------------------------------------------------------*/

    tmc_settings: {},

    /*-----------------------------------------------------------------------------------*/
    /* tinyMCE defaults
    /*-----------------------------------------------------------------------------------*/

    tmc_defaults: {
        theme: "modern",
        menubar: false,
        wpautop: true,
        indent: false,
        toolbar1: "bold,italic,underline,blockquote,strikethrough,bullist,numlist,alignleft,aligncenter,alignright,undo,redo,link,unlink,fullscreen",
        plugins: "fullscreen,image,wordpress,wpeditimage,wplink",
        max_height: 500
    },

    /*-----------------------------------------------------------------------------------*/
    /* quicktags settings
    /*-----------------------------------------------------------------------------------*/

    qt_settings: {},

    /*-----------------------------------------------------------------------------------*/
    /* quicktags defaults
    /*-----------------------------------------------------------------------------------*/

    qt_defaults: {
        buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,fullscreen"
    },

    model: Generate_Sections.Section,

    events: {
        "click .media-modal-backdrop, .media-modal-close, .media-button-close": "closeModal",
        "click .media-button-insert": "saveModal",
        "click .media-menu-item": "switchTab",
        "keydown": "keydown",
        "click .generate-sections-upload-button": "openMediaUploader",
        "click .generate-sections-remove-image": "removeImage",
        "click div.media-frame-title h1": "toggleMenu"
    },



    /**
     * Simple object to store any UI elements we need to use over the life of the application.
     */
    ui: {
        nav: undefined,
        content: undefined
    },


    /**
     * Instantiates the Template object and triggers load.
     */
    initialize: function() {
        _.bindAll(this, "render", "closeModal", "saveModal", "switchTab");

        this.focusManager = new wp.media.view.FocusManager({
            el: this.el
        });

        this.changeInsertText();
        this.tinyMCEsettings();
        this.render();
    },

    /**
     * switch the insert button text to "insert section"
     */
    changeInsertText: function(restore) {

        var restore = typeof restore !== 'undefined' && restore == true ? true : false;

        if (restore == false && typeof(wp.media.view.l10n.insertIntoPost) !== "undefined") {
            this.insertIntoPost = wp.media.view.l10n.insertIntoPost;
            wp.media.view.l10n.insertIntoPost = generate_sections_metabox_i18n.insert_into_section;
            // switch the insert button text back
        } else if (restore == true && typeof(this.insertIntoPost) !== "undefined") {
            wp.media.view.l10n.insertIntoPost = this.insertIntoPost;
        }
    },


    /**
     * Merge the default TinyMCE settings
     */
    tinyMCEsettings: function() {
        // get the #content"s tinyMCE settings or use default
        var init_settings = typeof tinyMCEPreInit == "object" && "mceInit" in tinyMCEPreInit && "content" in tinyMCEPreInit.mceInit ? tinyMCEPreInit.mceInit.content : this.tmc_defaults;

        // get the #content"s quicktags settings or use default
        var qt_settings = typeof tinyMCEPreInit == "object" && "qtInit" in tinyMCEPreInit && "content" in tinyMCEPreInit.qtInit ? tinyMCEPreInit.qtInit.content : this.qt_defaults;

        var _this = this;
        var custom_settings = {
            selector: "#generate-sections-editor",
            wp_autoresize_on: false,
            cache_suffix: "",
            min_height: 300,
        }

        // merge our settings with WordPress" and store for later use
        this.tmc_settings = $.extend({}, init_settings, custom_settings);

        this.qt_settings = $.extend({}, qt_settings, {
            id: "generate-sections-editor"
        });
    },


    /**
     * Assembles the UI from loaded template.
     * @internal Obviously, if the template fail to load, our modal never launches.
     */
    render: function() {

        "use strict";

        // Build the base window and backdrop, attaching them to the $el.
        // Setting the tab index allows us to capture focus and redirect it in Application.preserveFocus
        this.$el.attr("tabindex", "0")
            .html(this.template);

        // Handle any attempt to move focus out of the modal.
        //jQuery(document).on("focusin", this.preserveFocus);

        // set overflow to "hidden" on the body so that it ignores any scroll events while the modal is active
        // and append the modal to the body.
        jQuery("body").addClass("generate-modal-open").prepend(this.$el);

        // aria hide the background
        jQuery("#wpwrap").attr("aria-hidden", "true");

        this.renderContent();

        this.renderPreview();

        this.selected();
        this.colorPicker();
        this.startTinyMCE();

        // Set focus on the modal to prevent accidental actions in the underlying page
        this.$el.focus();

        return this;
    },

    /**
     * Make the menu mobile-friendly
     */
    toggleMenu: function() {
        this.$el.find('.media-menu').toggleClass('visible');
    },

    /**
     * Create the nav tabs & panels
     */
    renderContent: function() {

        var model = this.model;

        var menu_item = wp.template("generate-sections-modal-menu-item");

        // Save a reference to the navigation bar"s unordered list and populate it with items.
        this.ui.nav = this.$el.find(".media-menu");

        // reference to content area
        this.ui.panels = this.$el.find(".media-frame-content");

        // loop through the tabs
        if (generate_sections_metabox_i18n.tabs.length) {

            // for...of is nicer, but not supported by minify, so stay with for...in for now
            for (var tab in generate_sections_metabox_i18n.tabs) {

                if (generate_sections_metabox_i18n.tabs.hasOwnProperty(tab)) {

                    tab = generate_sections_metabox_i18n.tabs[tab];

                    var $new_tab = $(menu_item({
                        target: tab.target,
                        name: tab.title
                    }));

                    var panel = wp.template("generate-sections-edit-" + tab.target);

                    var $new_panel = $(panel(model.toJSON()));

                    if (tab.active == "true") {
                        $new_tab.addClass("active");
                        $new_panel.addClass("active");
                    }

                    this.ui.nav.append($new_tab);
                    this.ui.panels.append($new_panel);
                }
            }
        }

    },


    /**
     * Render the background image preview
     */
    renderPreview: function(image_id) {

        var image_id = typeof image_id !== 'undefined' ? image_id : this.model.get("background_image");

        var $preview = $("#generate-section-image-preview");
        $preview.children().remove();

        if (image_id > 0) {
            this.background = new wp.media.model.Attachment.get(image_id);

            this.background.fetch({
                success: function(att) {
                    if (_.contains(['png', 'jpg', 'gif', 'jpeg'], att.get('subtype'))) {
                        $("<img/>").attr("src", att.attributes.sizes.thumbnail.url).appendTo($preview);
                        $preview.next().find(".generate-sections-remove-image").show();
                    }
                }
            });
        }

    },


    /**
     * Set the default option for the select boxes
     */
    selected: function() {

        var _this = this;

        this.$el.find("select").each(function(index, select) {

            var attribute = jQuery(select).attr("name");
            var selected = _this.model.get(attribute);
            jQuery(select).val(selected);

        });
    },

    /**
     * Start the colorpicker
     */
    colorPicker: function() {
        this.$el.find(".generate-sections-color").wpColorPicker();
    },

    /**
     * Start TinyMCE on the textarea
     */
    startTinyMCE: function() {

        // set the default editor
        this.ui.panels.find("#wp-generate-sections-editor-wrap").addClass(generate_sections_metabox_i18n.default_editor);

        // remove tool buttons if richedit disabled
        if (!generate_sections_metabox_i18n.user_can_richedit) {
            this.ui.panels.find(".wp-editor-tabs").remove();
        }

        // add our copy to the collection in the tinyMCEPreInit object because switch editors
        if (typeof tinyMCEPreInit == 'object') {
            tinyMCEPreInit.mceInit["generate-sections-editor"] = this.tmc_settings;
            tinyMCEPreInit.qtInit["generate-sections-editor"] = this.qt_settings;
        }

        try {

            var rich = (typeof tinyMCE != "undefined");

            // turn on the quicktags editor
            quicktags(this.qt_settings);

            // attempt to fix problem of quicktags toolbar with no buttons
            QTags._buttonsInit();

            if (rich !== false) {
                // turn on tinyMCE
                tinyMCE.init(this.tmc_settings);
            }

        } catch (e) {}

    },

    /**
     * Launch Media Uploader
     */
    openMediaUploader: function(e) {

        var _this = this;

        $input = jQuery(e.currentTarget).prev("#generate-sections-background-image");

        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (this.mediaUploader) {
            this.mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        this.mediaUploader = wp.media.frames.file_frame = wp.media({
            title: generate_sections_metabox_i18n.media_library_title,
            button: {
                text: generate_sections_metabox_i18n.media_library_button
            },
            multiple: false
        });


        // When a file is selected, grab the URL and set it as the text field"s value
        this.mediaUploader.on("select", function() {

            attachment = _this.mediaUploader.state().get("selection").first().toJSON();

            $input.val(attachment.id);

            _this.renderPreview(attachment.id);
        });
        // Open the uploader dialog
        this.mediaUploader.open();

    },

    /**
     * Remove the background image
     */
    removeImage: function(e) {
        e.preventDefault();
        $("#generate-section-image-preview").children().remove();
        $("#generate-section-image-preview").next().find(".generate-sections-remove-image").hide();
        $("#generate-sections-background-image").val("");
    },


    /**
     * Closes the modal and cleans up after the instance.
     * @param e {object} A jQuery-normalized event object.
     */
    closeModal: function(e) {
        "use strict";

        e.preventDefault();
        this.undelegateEvents();
        jQuery(document).off("focusin");
        jQuery("body").removeClass("generate-modal-open");

        // remove restricted media modal tab focus once it's closed
        this.$el.undelegate('keydown');

        // remove modal and unset instances
        this.remove();
        Generate_Sections.backbone_modal.__instance = undefined;
        this.mediaUploader = null;
        Generate_Sections.modalOpen = null;

        // remove the tinymce editor
        if (typeof tinyMCE != "undefined") {
            tinymce.EditorManager.execCommand("mceRemoveEditor", true, "generate-sections-editor");
        }

        // switch the insert button text back
        this.changeInsertText(true);

        // send focus back to where it was prior to modal open
        Generate_Sections.lastFocus.focus();

        // aria unhide the background
        jQuery("#wpwrap").attr("aria-hidden", "false");

    },

    /**
     * Responds to the btn-ok.click event
     * @param e {object} A jQuery-normalized event object.
     * @todo You should make this your own.
     */
    saveModal: function(e) {
        "use strict";

        this.model.get("index");

        var model = this.model;

        // send the tinymce content to the textarea
        if (typeof tinyMCE != "undefined") {
            tinymce.triggerSave();
        }

        var $inputs = this.ui.panels.find("input, select, textarea");

        $inputs.each(function(index, input) {

            var name = $(input).attr("name");

            if (model.attributes.hasOwnProperty(name)) {
                var value = $(input).val();
                model.set(name, value);
            }

        });

        this.closeModal(e);
    },

    /**
     * Handles tab clicks and switches to corresponding panel
     * @param e {object} A jQuery-normalized event object.
     */
    switchTab: function(e) {
        "use strict";
        e.preventDefault();
		
		// close lingering wp link windows
		if (typeof tinyMCE != "undefined") {
			tinyMCE.activeEditor.execCommand('wp_link_cancel');
		}

        this.ui.nav.children().removeClass("active");
        this.ui.panels.children().removeClass("active");

        var target = jQuery(e.currentTarget).addClass("active").data("target");

        this.ui.panels.find("div[data-id=" + target + "]").addClass("active");
    },

    /**
     * close on keyboard shortcuts
     * @param {Object} event
     */
    keydown: function(e) {
        // Close the modal when escape is pressed.
        if (27 === e.which && this.$el.is(':visible')) {
            this.closeModal(e);
            e.stopImmediatePropagation();
        }
    }

});
