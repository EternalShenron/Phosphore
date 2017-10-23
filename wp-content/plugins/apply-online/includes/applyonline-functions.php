<?php

/**
 * Returns rich application form. 
 *
 * @since    1.6
 * @access   public
 * @var      string    $post_id    Post id.
 * @return   array     Application form fields.
 */
function aol_form($post_id = 0){
    $aol = new SinglePostTemplate();
    return $aol->application_form($post_id);
}

/**
 * Returns array of application features. 
 *
 * @since    1.6
 * @access   public
 * @var      string    $post_id    Post id.
 * @return   array     Application form fields.
 */
function aol_features($post_id = 0){
    $aol = new SinglePostTemplate();
    return $aol->ad_features();
}

/**
 * Returns array of application form fields. 
 *
 * @since    1.6
 * @access   public
 * @var      string    $post_id    Post id.
 * @return   array     Application form fields.
 */
function aol_form_fields($post_id = 0){
    $aol = new SinglePostTemplate();
    return $aol->application_form_fields($post_id);
}

/**
 * Returns array of application form fields in correct order. 
 *
 * @since    1.6
 * @access   public
 * @var      string    $post_id    Post id.
 * @return   array     Application form fields.
 */
function get_aol_ad_post_meta($post_id){
    $form_fields = array();
    $keys_order = get_post_meta($post_id, '_aol_fields_order', TRUE);
    $metas = get_post_meta($post_id);
    
    //If fields order is not set in DB then fetch all form fields without order.
    if(empty($keys_order)){
        foreach ($metas as $key => $val){ 
            if(substr($key, 0, 9) == '_aol_app_') $form_fields[$key] = unserialize ($val[0]);
        }
    }
    //Get fields according to field order.
    else{
        foreach ($keys_order as $key){
            $form_fields[$key] = unserialize($metas[$key][0]);
        }
    }
    
    return $form_fields;
}