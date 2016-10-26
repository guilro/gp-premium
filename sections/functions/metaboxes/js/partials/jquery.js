/*-----------------------------------------------------------------------------------*/
/* Execute the above methods in the Generate_Sections object.
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

    Generate_Sections.initApplication();

    $('#generate_sections_container').sortable({
        axis: "y",
        opacity: 0.5,
        grid: [20, 10],
        tolerance: "pointer",
        handle: ".move-section",
        update: function(event, ui) {
            ui.item.trigger("reorder", ui.item.index());
        }
    });

    // Show/hide on load
    if ('true' == jQuery('#_generate_use_sections_metabox select').val()) {
        generateShowSections();
    } else {
        generateHideSections();
    }

    // Show/hide on change
    jQuery('select[name="_generate_use_sections[use_sections]"]').change(function() {
        if (jQuery(this).val() == 'true') {
            generateShowSections();
        } else {
            generateHideSections();
        }
    });

    function generateShowSections() {

        // Hide send to editor button
        $('.send-to-editor').css('display', 'none');

        // Hide the editor
        $('#postdivrich').css({
            'opacity': '0',
            'height': '0',
            'overflow': 'hidden'
        });

        // Show the sections
        $('#_generate_sections_metabox').css({
            'opacity': '1',
            'height': 'auto'
        });

        $('body').trigger('generate_show_sections');

    }

    function generateHideSections() {

        // Show send to editor button
        $('.send-to-editor').css('display', 'inline-block');

        // Show the editor
        $('#postdivrich').css({
            'opacity': '1',
            'height': 'auto'
        });

        // Hide the sections
        $('#_generate_sections_metabox').css({
            'opacity': '0',
            'height': '0',
            'overflow': 'hidden'
        });

        $('body').trigger('generate_hide_sections');

    }


});
