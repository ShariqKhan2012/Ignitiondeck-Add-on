<?php
/*
Plugin Name: IgnitionDeck Add-on
Plugin URI:  
Description: Plugin to add some fields to the campaign creation form.
Author: Shariq Khan
Version: 1.0.0
*/
?>
<?php
/**
 * @since 1.0.0
 * Hooked to plugins_loaded . To load the translations.
 *
 * @param None.
 */
function shkid_load_textdomain() {
	load_plugin_textdomain( 'ignitiondeck-addon', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('plugins_loaded', 'shkid_load_textdomain');

 /**
 * @since 1.0.0
 * Hooked to id_fes_form_init filter.
 * Adds extra fields to the default FRONTEND ID project creation form
 * Insert this field after the Project FAQs field
 *
 * @param $form 		The form object
 * @param $vars 		Array to populate form fields from
 * 
 * @return Nothing
 */
function shkid_add_custom_fields($form, $vars) {
	//If your field name is shkid_sample_text, 
	//then it will be saved in post meta as ign_shkid_sample_text
	
	$val = get_post_meta($vars['post_id'], 'ign_shkid_sample_text', true);

	$field = array(
		'label' => 'Sample Text Field',
		'value' => (isset($val) ? $val : ''),
		'name' => 'shkid_sample_text',	
		'id' => 'shkid_sample_text',
		'type' => 'text',
		'wclass' => 'form-row full left some_other_class'
	);
	
	$temp_form = array();
	
	if(!empty($form)) {
		foreach($form as $form_field) {
			$temp_form[] = 	$form_field;
			if($form_field['id'] == 'project_faq') { //We are inserting our custom field AFTER 'Project FAQs'
				$temp_form[] = $field;
			}
		}
		$form = $temp_form;
	}
	else {
		$form[] = $field;
	}
	
	return $form;
}
add_filter('id_fes_form', 'shkid_add_custom_fields',11,2);


 /**
 * @since 1.0.0
 * Hooked to id_postmeta_boxes filter.
 * Adds extra fields to the default BACKEND ID project creation form
 *
 * @param $meta_boxes 	Array containing existing metaboxes(form fields)
 * 
 * @return Nothing
 */
function shkid_add_custom_fields_in_backend($meta_boxes) {
	$prefix = 'ign_';
	$fields = $meta_boxes[0]['fields'];
	$new_fields = array();
	for ($i=0, $j=0 ; $i < count($fields) ; $i++, $j++) { 
		$new_fields[$j] = $fields[$i];
		// checking if the field is level title, then adding below it the textbox for exchange product
		if (isset($fields[$i]['id'])) {
			if ($new_fields[$j]['id'] == 'ign_faqs') {
				$j++;		
				$new_fields[$j] = array(
					'name' => __('Sample Text Field', 'ignitiondeck-addon'),
					'desc' => __('Add whatever help text you want to. Blah Blah Blah.', 'ignitiondeck-addon'),
					'id' => $prefix.'shkid_sample_text',
					'class' => $prefix . 'projectmeta_full',
					'show_help' => true,
					'type' => 'text'
				);
			}
		}
	}
	$meta_boxes[0]['fields'] = $new_fields;
	return $meta_boxes;
}
add_filter('id_postmeta_boxes', 'shkid_add_custom_fields_in_backend');


 /**
 * @since 1.0.0
 * Hooked to ide_fes_create and  ide_fes_update actions.
 * Updating the extra fields added to the default ID form
 *
 * @param $user_id 		ID of the current user creating/updating the form
 * @param $project_id 	Project Id of the project
 * @param $post_id 		Post Id of the project
 * @param $proj_args 	Project parameters like title, funding type etc.
 * @param $levels 		Levels associated with the project Id of the project
 * @param $auth 		Auth object
 * 
 * @return Nothing
 */
function shkid_update_custom_fields($user_id, $project_id, $post_id, $proj_args, $levels, $auth) {
	//IMPORTANT: You should sanitize the values before saving it
	if (isset($_POST['shkid_sample_text'])) {
		update_post_meta($post_id, 'ign_shkid_sample_text', $_POST['shkid_sample_text']);
	}
}
add_action('ide_fes_create', 'shkid_update_custom_fields', 5, 6);
add_action('ide_fes_update', 'shkid_update_custom_fields', 5, 6);