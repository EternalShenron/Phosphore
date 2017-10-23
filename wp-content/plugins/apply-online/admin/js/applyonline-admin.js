(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
        $(document).ready(function(){
            $('.datepicker').datepicker({
                minDate: +1,
            });
                $("#app_form_fields").sortable({
                  placeholder: "ui-state-highlight",
                  update: function( event, ui ) {
                      $('#aol_keys_order_wrapper').empty(); //
                      $( '#app_form_fields tr' ).each(function(){
                          var field = $(this).data( "id" );
                          $('#aol_keys_order_wrapper').append('<input type="hidden" id="aol_fields_order" name="_aol_fields_order[]" value="'+field+'" />');
                      });
                      
                  }
                });
                
            /*Ad editor Scripts*/

            /*Application Field Type change for new Field only*/
            $('#adapp_field_type').change(function(){
               var fieldType=$(this).val();

               if(fieldType == 'checkbox' || fieldType == 'dropdown' || fieldType == 'radio'){
                   $('#adapp_field_options').show();
               }
               else{
                   $('#adapp_field_options').hide();
                   $('#adapp_field_options').val('');
               }
            });

            /*Add Application Field (Group Fields)*/
            $('#addField').click(function(){
                var fieldNameRaw=$('#adapp_name').val(); // Get Raw value.
                var fieldNameRaw = fieldNameRaw.trim(); // Remove White Spaces from both ends.
                var fieldName = fieldNameRaw.replace(" ", "_"); //Replace white space with _.
                var fieldType = $('#adapp_field_type').val();
                var fieldOptions = $('#adapp_field_options').val();
                var style;


                var fieldTypeHtml = $('#adapp_field_type').html();
                if(fieldName != ''){
                    $('#adapp_name').css('border','1px solid #ddd');
                    if(fieldType=='text' || fieldType=='email' || fieldType=='date' || fieldType == 'text_area'|| fieldType == 'file'){
                        style = "display:none";
                    }
                    else {
                        style = "";
                        $('#adapp_field_options').val('');
                        $('#adapp_field_options').hide();
                    }
                    $('#app_form_fields').append('<tr class="'+fieldName+'"><td><label for="'+fieldName+'"><span class="dashicons dashicons-menu"></span> '+fieldNameRaw+'</label></td><td><input name="_aol_app_'+fieldName+'[required]" value="1" type="hidden"><div class="button-primary toggle-required">Required</div>  <select class="adapp_field_type" name="_aol_app_'+fieldName+'[type]">'+fieldTypeHtml+'</select><input type="text" class="'+fieldName+' adapp_field_options" name="_aol_app_'+fieldName+'[options]" value="'+fieldOptions+'" placeholder="Option1, Option2, Option3" style="'+style+'" /> &nbsp; <div class="button removeField">Delete</div></td></tr>');
                    $('#aol_keys_order_wrapper').append('<input type="hidden" id="aol_fields_order" name="_aol_fields_order[]" value="'+fieldName+'" />');
                    
                    $('.'+fieldName+' .'+fieldType).attr('selected','selected');
                    $('#adapp_name').val('');
                    $('#adapp_field_type').val('text');
                }
                else{
                    $('#adapp_name').css('border','1px solid #F00');

                }

            });

            /* Application Field Type change for existing fields. */
            $('#app_form_fields').on('change', 'tr td .adapp_field_type',function(){

                var fieldType=$(this).val();

                if(fieldType == 'checkbox' || fieldType == 'dropdown' || fieldType == 'radio'){
                   $(this).next().show();
                }
                else{
                   $(this).next().hide();
                }
            }); 


            /*Add Job Feature*/
            $('#addFeature').click(function(){
                var fieldNameRaw=$('#adfeature_name').val(); // Get Raw value.
                var fieldNameRaw = fieldNameRaw.trim();    // Remove White Spaces from both ends.
                var fieldName = fieldNameRaw.replace(" ", "_"); //Replace white space with _.

                var fieldVal = $('#adfeature_value').val();
                var fieldVal = fieldVal.trim();

                if(fieldName != '' && fieldVal!=''){
                    $('#ad_features').append('<li class="'+fieldName+'"><label for="'+fieldName+'">'+fieldNameRaw+'</label> <input type="text" name="_aol_feature_'+fieldName+'" value="'+fieldVal+'" > &nbsp; <div class="button removeField">Delete</div></li>');
                    $('#adfeature_name').val(""); //Reset Field value.
                    $('#adfeature_value').val(""); //Reset Field value.
                }
            });
            /*Remove Job app or ad Feature Fields*/
            $('.adpost_fields').on('click', 'li .removeField',function(){
                $(this).parent('li').remove();
            });
            $('#app_form_fields').on('click', 'tr td .removeField',function(){
                $(this).parentsUntil('tbody', 'tr').remove();
            });
            
            //Toggle Required
            $('.adpost_fields').on('click', 'tr .toggle-required', function(){
                var required = $(this).prev('input').val();
                $(this).prev('input').val(required === '1'? '0': '1');
                $(this).toggleClass('button-disabled');
            });
            /*END Ad editor Scripts*/
            
            $('.aol_ad_page_settings').find('.tab-data:first').show();
            $('.aol_ad_page_settings').find('.nav-tab').click(function(){
                $('.aol_ad_page_settings').find('.nav-tab').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');

                var target = $(this).data("id");

                $('.aol_ad_page_settings').find('.tab-data').hide();
                $("#"+target).show();
            });
            
            
            $('#aol_submission_default').click(function(event){
                event.preventDefault();
                $('#aol_submission_default_message').val(aol_admin.app_submission_message);
                $('#aol_submission_default_message').text(aol_admin.app_submission_message);
            });
            
            $('#aol_required_fields_button').click(function(event){
                event.preventDefault();
                $('#aol_required_fields_notice').val(aol_admin.aol_required_fields_notice);
                $('#aol_required_fields_notice').text(aol_admin.aol_required_fields_notice);
            });
         });
})( jQuery );