// init
Generate_Sections.initApplication = function() {

    // Create Collection From Existing Meta
    Generate_Sections.sectionCollection = new Generate_Sections.SectionsCollection(generate_sections_metabox_i18n.sections);

    // Create the List View
    Generate_Sections.sectionList = new Generate_Sections.sectionListView({
        collection: Generate_Sections.sectionCollection
    });
    Generate_Sections.sectionList.render();

    // Buttons
    Generate_Sections.Buttons = new Generate_Sections.ButtonControls({
        collection: Generate_Sections.sectionCollection
    });
    Generate_Sections.Buttons.render();

};
