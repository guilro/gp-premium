// The Buttons & Nonce
Generate_Sections.ButtonControls = Backbone.View.extend({

    attributes: {
        class: "generate_sections_buttons"
    },

    tagName: 'p',

    el: "#_generate_sections_metabox",

    template: wp.template("generate-sections-buttons"),

    // Attach events
    events: {
        "click .button-primary": "newSection",
        "click #generate-delete-sections": "clearAll",
        'click .edit-section': 'editSection',
    },

    // create new 
    newSection: function(e) {
        e.preventDefault();
        var newSection = new Generate_Sections.Section();
        Generate_Sections.sectionList.addSection(newSection);
    },

    // clear all models 
    clearAll: function(e) {
        e.preventDefault();
        if (confirm(generate_sections_metabox_i18n.confirm)) {
            Generate_Sections.sectionCollection.reset();
            Generate_Sections.sectionList.render();
        }
    },

    render: function() {
        this.$el.find(".generate_sections_control").append(this.template);
        return this;
    },

});
