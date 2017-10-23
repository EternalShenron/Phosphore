<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wpreloaded.com/farhan-noor
 * @since      1.0.0
 *
 * @package    Applyonline
 * @subpackage Applyonline/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Applyonline
 * @subpackage Applyonline/public
 * @author     Farhan Noor <profiles.wordpress.org/farhannoor>
 */
class Applyonline_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

                new SinglePostTemplate($plugin_name, $version); //Passing 2 parameters to the child
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Applyonline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Applyonline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/applyonline-public.css', array(), $this->version, 'all' );
                wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Applyonline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Applyonline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/applyonline-public.js', array( 'jquery','jquery-ui-datepicker' ), $this->version, false );   
                wp_localize_script ( 
                    $this->plugin_name, 
                    'aol_public', 
                    array(
                        'ajaxurl' => admin_url ( 'admin-ajax.php' ),
                        'date_format'   => get_option('aol_date_format', 'dd-mm-yy')
                        )
                );
	}
}

class SinglePostTemplate extends Applyonline_Public{
        public function __construct() {
            add_filter('body_class', array($this, 'aol_body_classes'));
            add_filter( 'the_content', array($this, 'aol_content') );
        }
    
        function aol_body_classes($classes){
            $classes[] = $this->plugin_name;
            $classes[] = $this->plugin_name.'-'.$this->version;
            return $classes;
        }
        public function aol_ad_is_checked($i){
            if($i==0) $checked="checked";
            else $checked = NULL;
            return $checked;
        }

        public function application_form_fields($post_id=0){
            //Get current post object on SINGLE Template file.
            global $post;
            if(empty($post_id)) $post_id = $post->ID;
            
            $field_types = array('text'=>'Text', 'checkbox'=>'Check Box', 'dropdown'=>'Drop Down', 'radio'=> 'Radio', 'file'=> 'File');
            
            $raw_fields = get_aol_ad_post_meta($post_id);
            $fields = array();
            $i=0;
            foreach($raw_fields as $key => $val){
                    $fields[$i] = $val; //
                    $fields[$i]['key'] = substr($key, 9); //Add key as array element for easy access.
                    $fields[$i]['options'] = explode(',', $fields[$i]['options']); //Add options as an array. 
                    if(!isset($fields[$i]['required'])) $fields[$i]['required'] = 1; //Fix for older versions (prior to 1.6.1 when REQUIRED field was not available)
                    $i++;
            } 
            return $fields;
            //Debuggin
        }        

        public function application_form($post_id = 0){
            ob_start();
            $fields = $this->application_form_fields($post_id); 
            ?>
            <form class="aol_app_form" name="aol_app_form" id="aol_app_form" enctype="multipart/form-data"  data-toggle="validator">
                <?php 
                    foreach($fields as $field){
                    if(isset($field['required']) AND $field['required'] == '1'){
                        $required = '*'; $req_class = 'required';
                    } else $required = $req_class = null;
                    
                        switch ($field['type']){
                            case 'text':
                            case 'email':
                            case 'file':
                                echo '<div class="form-group"><label for="'.$field['key'].'">'.$required.str_replace('_',' ',$field['key']).'</label><input type="'.$field['type'].'" name="_aol_app_'.$field['key'].'" class="form-control" id="'.$field['key'].'" '.$req_class.'></div>';
                                break;

                            case 'text_area':
                                echo '<div class="form-group"><label for="'.$field['key'].'">'.$required.str_replace('_',' ',$field['key']).'</label><textarea name="_aol_app_'.$field['key'].'" class="form-control" id="'.$field['key'].'" '.$req_class.'></textarea></div>';
                                break;

                            case 'date': echo '<div class="form-group"><label for="'.$field['key'].'">'.$required.str_replace('_',' ',$field['key']).'</label><input type="text" name="_aol_app_'.$field['key'].'" class="form-control datepicker" id="'.$field['key'].'" placeholder="'.__('example', 'apply-online').': '.current_time(get_option('date_format')).'" '.$req_class.'></div>';
                                break;

                            case 'dropdown': echo '<div class="form-group"><label for="'.$field['key'].'">'.$required.str_replace('_',' ',$field['key']).'</label><div id="'.$field['key'].'" ><select name="_aol_app_'.$field['key'].'" id="'.$field['key'].'" class="form-control '.$field['key'].'" '.$req_class.'>';
                                foreach ($field['options'] as $option) {
                                    echo '<option class="" value="'.$option.'" >'.$option.' </option>';
                                }
                                echo '</select></div></div>';
                                break;

                            case 'radio':
                                echo '<div class="form-group"><label for="'.$field['key'].'">'.$required.str_replace('_',' ',$field['key']).'</label><div id="'.$field['key'].'" >';
                                $options=$field['options'];
                                $i=0;
                                foreach ($options as $option) {
                                    echo '<input type="'.$field['type'].'" name="_aol_app_'.$field['key'].'" class="aol-radio '.$field['key'].'" id="'.$field['key'].'" value="'.$option.'"  '.$this->aol_ad_is_checked($i).'>'.$option.' &nbsp; &nbsp; ';
                                    $i++;
                                }
                                echo '</div></div>';
                                break;
                            case 'checkbox':
                                echo '<div class="form-group"><label for="'.$field['key'].'">'.$required.str_replace('_',' ',$field['key']).'</label><div id="'.$field['key'].'" >';
                                $options=$field['options'];
                                $i=0;
                                foreach ($options as $option) {
                                    echo '<input type="'.$field['type'].'" name="_aol_app_'.$field['key'].'[]" class="aol-checkbox '.$field['key'].'" id="'.$field['key'].'" value="'.$option.'"  '.$this->aol_ad_is_checked($i).'>'.$option.' &nbsp; &nbsp; ';
                                    $i++;
                                }
                                echo '</div></div>';
                                break;
                        }
                    }
                    do_action('aol_after_form_fields', $post_id);
                ?>
                <p><small><i><?php _e(get_option('aol_required_fields_notice', 'Fields with (*)  are compulsory.'), 'apply-online'); ?></i></small></p>
                <input type="hidden" name="ad_id" value="<?php the_ID(); ?>" >
                <input type="hidden" name="action" value="aol_app_form" >
                <input type="hidden" name="wp_nonce" value="<?php echo wp_create_nonce( 'the_best_aol_ad_security_nonce' ) ?>" >
                <input type="submit" value="<?php echo __('Submit', 'apply-online'); ?>" class="btn btn-primary" id="aol_app_submit_button">
            </form>
                <p id="aol_form_status"></p>
        <?php
            return ob_get_clean();
        }

        public function ad_features($post_id = 0) {
            //Get current post object on SINGLE Template file.
            global $post;
            if(empty($post_id)) $post_id = $post->ID;
            
            $raw_fields = get_post_meta($post_id);
            $fields = array();
            $i=0;
            foreach($raw_fields as $key => $val){
                if(substr($key, 0, 13) == '_aol_feature_'){
                    $fields[$key] = $val[0]; //
                }
            }

            $metas = NULL;
            if( !empty($fields) ):
                $metas='<table class="aol_ad_features">';
                foreach($fields as $key => $val):
                        $metas.= '<tr><td>'.str_replace('_',' ',substr($key,13)).'</td><td>'.$val.' </td></tr>';
                endforeach;
            $metas.='</table>';
            endif;
          return $metas;
        }

        public function aol_content($content){
            global $post;
            global $template;
            $title_form = '<h3 class="aol-heading">'.__('Apply Online', 'apply-online').'</h3>';
            $features = $this->ad_features($post->ID);
            $title_features = empty($features) ? NULL : '<h4 class="aol-heading-features">'.__('Salient Features', 'apply-online').'</h4>';
            $form = $this->application_form();

            //Show this content if you are viewing aol_ad post type using single.php (not with single-aold_ad.php)
            if(is_singular('aol_ad') and 'single-aol_ad.php' != wp_basename($template)):
                $content = '<div class="aol-single-ad">'.$content.$title_features.$features.$title_form.$form.'</div>';
            endif;
            return apply_filters( 'aol_content', $content, $features, $form );
        }
}