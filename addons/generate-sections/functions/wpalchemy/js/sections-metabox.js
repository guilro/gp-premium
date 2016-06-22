/*-----------------------------------------------------------------------------------*/
/* KIA Metabox scripts
/*
/* upload media buttons, sort, repeatable tinyMCE fields 
/* requires WordPress 3.9
/*
/* © Kathy Darling http://www.kathyisawesome.com
/* 2012-03-07. */
/*-----------------------------------------------------------------------------------*/


;(function ($) {

var SECTIONS_metabox = {

	/*-----------------------------------------------------------------------------------*/
	/* All the matching text areas 
	/*-----------------------------------------------------------------------------------*/

	textareas: {},

	/*-----------------------------------------------------------------------------------*/
	/* tinyMCE settings
	/*-----------------------------------------------------------------------------------*/

	tmc_settings: {},

	/*-----------------------------------------------------------------------------------*/
	/* tinyMCE defaults
	/*-----------------------------------------------------------------------------------*/

	tmc_defaults: {
		theme: 'modern',
		menubar: false,
		wpautop: true,
		indent: false,
		toolbar1: 'bold,italic,underline,blockquote,strikethrough,bullist,numlist,alignleft,aligncenter,alignright,undo,redo,link,unlink,fullscreen',
		plugins: 'fullscreen,image,wordpress,wpeditimage,wplink'
	},

	/*-----------------------------------------------------------------------------------*/
	/* quicktags settings
	/*-----------------------------------------------------------------------------------*/

	qt_settings: {},

	/*-----------------------------------------------------------------------------------*/
	/* quicktags defaults
	/*-----------------------------------------------------------------------------------*/

	qt_defaults: {
		buttons: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,fullscreen'
	},

	/*-----------------------------------------------------------------------------------*/
	/* Launch TinyMCE-enhanced textareas
	/*-----------------------------------------------------------------------------------*/

	runTinyMCE: function() {
	
		var rich = (typeof tinyMCE != "undefined");

		// get the #content's tinyMCE settings or use default
		var init_settings = typeof tinyMCEPreInit == 'object' && 'mceInit' in tinyMCEPreInit && 'content' in tinyMCEPreInit.mceInit ? tinyMCEPreInit.mceInit.content : SECTIONS_metabox.tmc_defaults;

		// get the #content's quicktags settings or use default
		SECTIONS_metabox.qt_settings = typeof tinyMCEPreInit == 'object' && 'qtInit' in tinyMCEPreInit && 'content' in tinyMCEPreInit.qtInit ? tinyMCEPreInit.qtInit.content : SECTIONS_metabox.qt_defaults;

		var custom_settings = {
			plugins : "charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,wordpress,wpeditimage,wpgallery,wplink,wpdialogs",
			resize : 'vertical'
		}

		// merge our settings with WordPress' and store for later use
		SECTIONS_metabox.tmc_settings = $.extend( {}, init_settings, custom_settings );

		//all custom text areas, except the one to copy
		SECTIONS_metabox.textareas = $('div.wpa_group:not(.tocopy) textarea.wp-sections-area'); 
		
		//give each a unique ID, TinyMCE will need it later
		SECTIONS_metabox.textareas.each( function( i ) {  
			var id = $(this).attr( 'id' );
			if ( !id) {
				id = 'mceEditor-' + ( i );
				$( this ).attr( 'id', id );
			}  

			
			// for some reason in WP I am required to do this in the loop 
			// SECTIONS_metabox.tmc_settings.selector is insufficient, anyone who can tell my why gets a margarita
			var tmc_settings = $.extend( {}, SECTIONS_metabox.tmc_settings, { selector : "#" + id } );

			var qt_settings = $.extend( {}, SECTIONS_metabox.qt_settings, { id : id } );

			// add our copy to he collection in the tinyMCEPreInit object because switch editors
			// will look there for an wpautop setting specific to this editor
			// similarly quicktags will product a toolbar with no buttons: https://core.trac.wordpress.org/ticket/26183
			if ( typeof tinyMCEPreInit == 'object' ){
				tinyMCEPreInit.mceInit[id] = tmc_settings;
				tinyMCEPreInit.qtInit[id] = qt_settings;
			}

			// turn on the quicktags editor for each
			quicktags( qt_settings );

			if ( rich !== false ) {
				// turn on tinyMCE for each
				tinymce.init( tmc_settings );
			}

			// fix media buttons
			$(this).closest('.customEditor').find('.insert-media').data( 'editor', id );

			// fix ultimate shortcodes button
			$(this).closest('.customEditor').find('.su-generator-button').data( 'target', id );
			
			// Fix switch editor functionality
			$(this).closest('.customEditor').find('.wp-switch-editor').data( 'wp-editor', id );

		});  //end each	
		
		$('.wpa_group:not(.tocopy) .generate-sections-color').each( function() {
			if ( ! $(this).data('wpWpColorPicker') ) {
				$(this).wpColorPicker( {
					change: $(this).trigger( 'change' )
				});
			}
		});
		
		if ( rich == false ) {
			$( '.customEditor .wp-editor-tabs' ).hide();
			$( '.customEditor .quicktags-toolbar' ).show();
		}

	} , //end runTinyMCE text areas 

	/*-----------------------------------------------------------------------------------*/
	/* Apply TinyMCE to new textareas
	/*-----------------------------------------------------------------------------------*/

	newTinyMCE: function( clone ) { 
	
		var rich = (typeof tinyMCE != "undefined");

		// count all custom text areas, except the one to copy
		count = SECTIONS_metabox.textareas.length;
			
		// assign the new textarea an ID
		id = 'mceEditor-' + count;
		$new_textarea = clone.find( 'textarea.wp-sections-area' ).attr( 'id', id );

		// fix media buttons
		$new_textarea.closest('.customEditor').find('.insert-media').data( 'editor', id );

		// fix ultimate shortcodes button
		$new_textarea.closest('.customEditor').find('.su-generator-button').data( 'target', id );
		
		// Fix switch editor functionality
		$new_textarea.closest('.customEditor').find('.wp-switch-editor').data( 'wp-editor', id );

		// add new textarea to collection
		SECTIONS_metabox.textareas.push( $new_textarea );
		 
		// Merge new selector into settings
		var tmc_settings = $.extend( {}, SECTIONS_metabox.tmc_settings, { selector : "#" + id } );

		var qt_settings = $.extend( {}, SECTIONS_metabox.qt_settings, { id : id } );

		// add our copy to he collection in the tinyMCEPreInit object because switch editors
		if ( typeof tinyMCEPreInit == 'object' ){
				tinyMCEPreInit.mceInit[id] = tmc_settings;
				tinyMCEPreInit.qtInit[id] = qt_settings;
		}

		try { 
			// turn on the quicktags editor for each
			quicktags( qt_settings );
			
			// attempt to fix problem of quicktags toolbar with no buttons
			QTags._buttonsInit();

			if ( rich !== false ) {
				// turn on tinyMCE
				tinyMCE.init( tmc_settings );
			}

		} catch(e){}
		
		$('.wpa_group:not(.tocopy) .generate-sections-color').each( function() {
			if ( ! $(this).data('wpWpColorPicker') ) {
				$(this).wpColorPicker( {
					change: $(this).trigger( 'change' )
				});
			}
		});
		
		if ( rich == false ) {
			$( '.customEditor .wp-editor-tabs' ).hide();
			$( '.customEditor .quicktags-toolbar' ).show();
		}
			
		
	} , //end runTinyMCE text areas 
			

	/*-----------------------------------------------------------------------------------*/
	/* Meta Fields Sorting
	/*-----------------------------------------------------------------------------------*/
	
	sortable: function(){

		var textareaID;
		var rich = (typeof tinyMCE != "undefined") && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden();
		
		$('.wpa_loop').sortable({
			//cancel: ':input,button,.customEditor', // exclude TinyMCE area from the sort handle
			handle: '.generate-sortable',
			axis: 'y',
			opacity: 0.5,
			tolerance: 'pointer',
			start: function(event, ui) { // turn TinyMCE off while sorting (if not, it won't work when resorted)
				if ( rich !== false ) {
					var textareaID = $(ui.item).find('textarea.wp-sections-area').attr('id');
					content = tinyMCE.editors[ textareaID ].getContent();
					tinyMCE.editors[ textareaID ].setContent('');
					tinyMCE.execCommand('mceRemoveEditor', false, textareaID); 
				}
			},
			stop: function(event, ui) { // re-initialize TinyMCE when sort is completed
				if ( rich !== false ) {
					var textareaID = $(ui.item).find('textarea.wp-sections-area').attr('id');
					if ( 'wp-sections-area tmce-enabled' == $(ui.item).find('textarea.wp-sections-area').attr('class') ) {
						tinyMCE.execCommand('mceAddEditor', false, textareaID); 
						tinyMCE.editors[ textareaID ].setContent( content );
					}
				}
				//$(this).find('.update-warning').show();
			},
			items : '.wpa_group:not(.tocopy)'
		});
		
	}, //end of sortable

	/*-----------------------------------------------------------------------------------*/
	/* A Simple Toggle switch 
	/*-----------------------------------------------------------------------------------*/

	toggleGroups : function(){
	
		var rich = (typeof tinyMCE != "undefined") && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden();

		$( '.wpa_loop' ).on( 'click', '.tmce-enabled .handle, .tmce-enabled .toggle', function( event ) {
		
			event.preventDefault();
		
			id = $(this).siblings('.group-inside').find('.customEditor').find('.wp-editor-container').find('.wp-sections-area').attr('id');
			
			$group = $(this).parents('.wpa_group'); 
			$toggle = $group.find('.toggle_state'); 
			$inside = $group.find('.group-inside'); 
			
			$inside.toggle( 0, function() {
			    $toggle.prop( 'checked', ! $toggle.prop( 'checked' ) );
			    $group.find( '.group-wrap' ).toggleClass( 'closed', $toggle.prop( 'checked' ) );
			});

		});
		
		$( '.wpa_loop' ).on( 'click', '.html-enabled .handle, .html-enabled .toggle', function( event ) {
		
			event.preventDefault();

			$group = $(this).parents('.wpa_group');
			$toggle = $group.find('.toggle_state');
			$inside = $group.find('.group-inside');
			
			$inside.toggle( 0, function() {
			    $toggle.prop( 'checked', ! $toggle.prop( 'checked' ) );
			    $group.find( '.group-wrap' ).toggleClass( 'closed', $toggle.prop( 'checked' ) );
			});

		});

	}, //end toggleGroups

	/*-----------------------------------------------------------------------------------*/
	/* Change Group Name via TinyMCE callback
	/*-----------------------------------------------------------------------------------*/

	changeName : function( ed ){

		//$('#' + ed.id ).closest('.wpa_group').find('.handle').html( ed.getContent({format : 'text'}).substring(0,50)  );

	}, //end changeName

	/*-----------------------------------------------------------------------------------*/
	/* Group Name
	/*-----------------------------------------------------------------------------------*/

	groupName : function( ed ){

		$( '.wpa_loop' ).on( 'change', 'textarea.wp-sections-area', function() {

			$group = $(this).parents('.wpa_group');
			$group.find('.handle').html( $(this).val().substring(0,50)  );

		});

	}, //end groupName

	/*-----------------------------------------------------------------------------------*/
	/* Switch Editors
	/*-----------------------------------------------------------------------------------*/

	switchEditors : function(){

		$( '.wpa_loop' ).on( 'click', '.wp-switch-editor.switch-tmce', function( event ) { 
		
			event.preventDefault();

			$wrapper = $(this).closest('.wp-editor-wrap');
			$wrapper.addClass('tmce-active');
			$wrapper.removeClass('html-active');
			$container = $(this).parent().parent().parent().parent().parent('.group-wrap');
			$container.removeClass('html-enabled');
			$container.addClass('tmce-enabled');

			id = $wrapper.find('textarea.wp-sections-area').attr('id');
			$wrapper.find('textarea.wp-sections-area').removeClass('html-enabled');
			$wrapper.find('textarea.wp-sections-area').addClass('tmce-enabled');
			mode = $(this).data('mode');
			switchEditors.go(id, mode);
			
		});
		
		$( '.wpa_loop' ).on( 'click', '.wp-switch-editor.switch-html', function( event ) { 
			
			event.preventDefault();
			$wrapper = $(this).closest('.wp-editor-wrap');
			$wrapper.removeClass('tmce-active');
			$wrapper.addClass('html-active');
			$container = $(this).parent().parent().parent().parent().parent('.group-wrap');
			$container.toggleClass('html-enabled');
			$container.addClass('html-enabled');
			$container.removeClass('tmce-enabled');
			
			id = $wrapper.find('textarea.wp-sections-area').attr('id');
			$wrapper.find('textarea.wp-sections-area').addClass('html-enabled');
			$wrapper.find('textarea.wp-sections-area').removeClass('tmce-enabled');
			mode = $(this).data('mode');
			
			switchEditors.go(id, mode);

		});

	}, //end switchEditors
	
	/*-----------------------------------------------------------------------------------*/
	/* Image upload
	/*-----------------------------------------------------------------------------------*/

	imageUpload : function(){
	
		jQuery('.wpa_loop').on('click', '.generate-sections-upload-button', function( event ){
		
			event.preventDefault();
			
			var button = $(this);
			
			// Uploading files
			var file_frame;

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
			  file_frame.open();
			  return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
			  title: jQuery( this ).data( 'uploader_title' ),
			  button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			  },
			  multiple: false
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {

			  // We set multiple to false so only get one image from the uploader
			  attachment = file_frame.state().get('selection').first().toJSON();

			  // Do something with attachment.id and/or attachment.url here
			  button.prev('input').val(attachment.id);
			  
			  // Create the preview
			  $( button ).parent().prev( '.image-preview' ).html( '<img src="' + attachment.url + '" alt="" width="50" height="50" />' );
			  
			  // Add the remove button
			  $( button ).next( '#remove_image' ).css( 'display','inline' );
			});

			// Finally, open the modal
			file_frame.open();
			
		});
		
		$( '.wpa_loop' ).on( 'click', '.generate-sections-remove-image', function( event ) {
		
			event.preventDefault();
		
			// Get upload button
			var upload_button = $(this).prev('#image_button');
			
			// Remove value from input
			$( upload_button ).prev( '.image_id' ).val('');
			
			// Remove preview
			$( upload_button ).parent().prev( '.image-preview' ).empty();
			
			// Remove this button
			$( this ).css( 'display','none' );
			
		});
		
	} // end imageUpload

}; // End SECTIONS_metabox Object // Don't remove this, or there's no guacamole for you

/*-----------------------------------------------------------------------------------*/
/* Execute the above methods in the SECTIONS_metabox object.
/*-----------------------------------------------------------------------------------*/
  
	$(document).ready(function () {
		
		SECTIONS_metabox.runTinyMCE();
		SECTIONS_metabox.sortable();
		SECTIONS_metabox.toggleGroups();
		//SECTIONS_metabox.groupName();
		SECTIONS_metabox.switchEditors();
		SECTIONS_metabox.imageUpload();

		//create a div to bind to
		if ( ! $.wpalchemy ) {
			$.wpalchemy = $('<div/>').attr('id','wpalchemy').appendTo('body');
		};
		
		// run our tinyMCE script on textareas when copy is made
		$( document.body ).on( 'wpa_copy', $.wpalchemy, function( event, clone ) { 		
			SECTIONS_metabox.newTinyMCE( clone );
		});
			
	});
	
	function generateShowSections()
	{
		
		// Hide send to editor button
		$('.send-to-editor').css('display','none');
				
		// Hide the editor
		$('#postdivrich').css({
			'opacity' : '0',
			'height' : '0',
			'overflow' : 'hidden'
		});
		
		// Show the sections
		$('#_generate_sections_metabox').css({
			'opacity' : '1',
			'height' : 'auto'
		});
			
		// Hide sidebar metabox
		$('#generate_layout_meta_box').hide();
		$('#generate_layout_meta_box-hide').prop('checked', false);
		
	}
		
	function generateHideSections()
	{
	
		// Show send to editor button
		$('.send-to-editor').css('display','inline-block');
				
		// Show the editor
		$('#postdivrich').css({
			'opacity' : '1',
			'height' : 'auto'
		});
		
		// Hide the sections
		$('#_generate_sections_metabox').css({
			'opacity' : '0',
			'height' : '0',
			'overflow' : 'hidden'
		});
			
		// Show sidebar metabox
		$('#generate_layout_meta_box').show();
		$('#generate_layout_meta_box-hide').prop('checked', true);
			
	}
	jQuery(window).load(function($) {
		
		// Show/hide on load
		if ( 'true' == jQuery('#_generate_use_sections_metabox select').val() ) {
			generateShowSections();
		} else {
			generateHideSections();
		}
			
		// Show/hide on change
		jQuery('select[name="_generate_use_sections[use_sections]"]').change(function(){
			if(jQuery(this).val() == 'true'){
				generateShowSections();
			} else {
				generateHideSections();
			}
		});
		
		jQuery(document).on('click','.send-to-editor',function(e){
			var sectionContent = '';
			
			// Check if TinyMCE is active
			var rich = (typeof tinyMCE != "undefined") && tinyMCE.get('content') && !tinyMCE.get('content').isHidden();
			
			if ( ! rich ) {
				alert( generate_sections.use_visual_editor );
				return false;
			}
					
			for (i=0; i < tinyMCE.editors.length; i++){
				sectionContent = sectionContent + tinyMCE.editors[i].getContent();
			}
					
			if ( '' == tinyMCE.get('content').getContent() ) {
				//jQuery( defaultEditor ).html( sectionContent );
				tinyMCE.get('content').setContent( sectionContent );
			} else {
				alert( generate_sections.no_content_error );
				return false;
			}
			
			return false;
				
		});
			
	});
  
})(jQuery);