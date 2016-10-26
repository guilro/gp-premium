// Singular View
Generate_Sections.sectionView = Backbone.View.extend({

    model: Generate_Sections.Section,
    tagName: 'div',

    initialize: function() {
        // re-render on all changes EXCEPT index
        this.listenTo(this.model, "change", this.maybeRender);
    },

    attributes: {
        class: "ui-state-default section"
    },

    // Get the template from the DOM
    template: wp.template("generate-sections-section"),

    events: {
        'click .edit-section': 'editSection',
        'click .section-title > span': 'editSection',
        'click .delete-section': 'removeSection',
        'click .toggle-section': 'toggleSection',
        'reorder': 'reorder',
    },

    maybeRender: function(e) {
        if (this.model.hasChanged('index')) return;
        this.render();
    },

    // Render the single model - include an index.
    render: function() {
        this.model.set('index', this.model.collection.indexOf(this.model));
        this.$el.html(this.template(this.model.toJSON()));

        if (!this.model.get('title')) {
            this.$el.find('h3.section-title > span').text(generate_sections_metabox_i18n.default_title);
        }
        this.$el.find('textarea').val(JSON.stringify(this.model));

        return this;
    },


    // launch the edit modal
    editSection: function(e) {

        // stash the current focus
        Generate_Sections.lastFocus = document.activeElement;
        Generate_Sections.modalOpen = true;

        e.preventDefault();
        if (Generate_Sections.backbone_modal.__instance === undefined) {
            Generate_Sections.backbone_modal.__instance = new Generate_Sections.backbone_modal.Application({
                model: this.model
            });
        }

    },

    // reorder after sort
    reorder: function(event, index) {
        this.$el.trigger('update-sort', [this.model, index]);
    },

    // remove/destroy a model
    removeSection: function(e) {
        e.preventDefault();
        if (confirm(generate_sections_metabox_i18n.confirm)) {
            this.model.destroy();
            Generate_Sections.sectionList.render(); // manually calling instead of listening since listening interferes with sorting
        }
    },
});
