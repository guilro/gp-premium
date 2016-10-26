// Collection
Generate_Sections.SectionsCollection = Backbone.Collection.extend({
    model: Generate_Sections.Section,
    el: "#generate_sections_container",
    comparator: function(model) {
        return model.get('index');
    }
});
