// List View
Generate_Sections.sectionListView = Backbone.View.extend({

    el: "#generate_sections_container",
    events: {
        'update-sort': 'updateSort',
        //     'add-section': 'addOne'
    },

    // callback for clone button
    addSection: function(model) {
        this.collection.add(model);
        this.addOne(model);
    },

    addOne: function(model) {
        var view = new Generate_Sections.sectionView({
            model: model
        });
        this.$el.append(view.render().el);
    },

    render: function() {
        this.$el.children().remove();
        this.collection.each(this.addOne, this);
        return this;
    },

    updateSort: function(event, model, position) {
        this.collection.remove(model);

        // renumber remaining models around missing model
        this.collection.each(function(model, index) {

            var new_index = index;
            if (index >= position) {
                new_index += 1;
            }
            model.set('index', new_index);
        });

        // set the index of the missing model
        model.set('index', position);

        // add the model back to the collection
        this.collection.add(model, {
            at: position
        });

        this.render();

    },

});
