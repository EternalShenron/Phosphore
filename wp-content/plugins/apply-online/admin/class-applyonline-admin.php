<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpreloaded.com/farhan-noor
 * @since      1.0.0
 *
 * @package    Applyonline
 * @subpackage Applyonline/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Applyonline
 * @subpackage Applyonline/admin
 * @author     Farhan Noor <profiles.wordpress.org/farhannoor>
 */
class Applyonline_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                
                // Hook - Applicant Listing - Column Name
                add_filter( 'manage_edit-aol_application_columns', array ( $this, 'applicants_list_columns' ) );

                // Hook - Applicant Listing - Column Value
                add_action( 'manage_aol_application_posts_custom_column', array ( $this, 'applicants_list_columns_value' ), 10, 2 ); 
                
                //Fix comments on application
                add_filter('comment_row_actions', array($this, 'comments_fix'), 10, 2);
                
                add_filter('post_row_actions',array($this, 'aol_post_row_actions'), 10, 2);
                
                //Filter Aplications based on parent.
                add_action( 'pre_get_posts', array($this, 'applications_filter') );
                
                // Add Application data to the Application editor. 
                add_action ( 'edit_form_after_title', array ( $this, 'aol_application_post_editor' ) );  
                
                //Application Print
                add_action('init', array($this, 'application_print'));
                                
                $this->hooks_to_search_in_post_metas();
                                
                new Applyonline_MetaBoxes();
                
                new Applyonline_Settings($version);
                
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/applyonline-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
            
                 $localize['app_submission_message'] = 'Form has been submitted successfully. We will get back to you very soon.'; 
                 $localize['aol_required_fields_notice'] = 'Fields with (*)  are compulsory.'; 

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/applyonline-admin.js', array( 'jquery', 'jquery-ui-sortable' ), $this->version, false );
                wp_localize_script( $this->plugin_name, 'aol_admin', $localize );
	}
        
        /**
        * Extend WordPress search to include custom fields
        * Join posts and postmeta tables
        *
        * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
         * 
         * @since 1.6
        */
        function hooks_to_search_in_post_metas(){
           add_filter('posts_join', array($this, 'cf_search_join' ));
           add_filter( 'posts_where', array($this, 'cf_search_where' ));
           add_filter( 'posts_distinct', array($this, 'cf_search_distinct' ));
        }
        
       function cf_search_join( $join ) {
           global $wpdb;

           if ( is_search() and is_admin() ) {    
               $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
           }

           return $join;
       }

       /**
        * Modify the search query with posts_where
        *
        * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
        * 
        * @since 1.6
        */
       function cf_search_where( $where ) {
           global $wpdb;

           if ( is_search() and is_admin() ) {
               $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
           }
           return $where;
       }

       /**
        * Prevent duplicates
        *
        * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
        * 
        * @since 1.6
        */
       function cf_search_distinct( $where ) {
           global $wpdb;

           if ( is_search() and is_admin() ) {
           return "DISTINCT";
       }

           return $where;
       }
        
       /**
        * 
        */
       public function comments_fix($actions, $comment){
            $post_id = $comment->comment_post_ID;
            if(get_post_field('post_type', $post_id) == 'aol_application'){
                $author = get_user_by('email', $comment->comment_author_email );
                if(get_current_user_id() != $author->ID) unset($actions['quickedit']); //if not comment author, dont show the quick edit
                unset($actions['unapprove']);
                unset($actions['trash']);
                unset($actions['edit']);
            }
            return $actions;                
        }
        
        /**
         * Applicant Listing - Column Name
         *
         * @param   array   $columns
         * @access  public
         * @return  array
         */
        public function applicants_list_columns( $columns ){
            $columns = array (
                'cb'       => '<input type="checkbox" />',
                'title'    => __( 'Ad Title', 'apply-online' ),
                'applicant'=> __( 'Applicant', 'apply-online' ),
                'taxonomy' => __( 'Categories', 'apply-online' ),
                'date'     => __( 'Date', 'apply-online' ),
            );
            return $columns;
        }

        /**
         * Applicant Listing - Column Value
         *
         * @param   array   $columns
         * @param   int     $post_id
         * @access  public
         * @return  void
         */
        // 
        public function applicants_list_columns_value( $column, $post_id ){
            $keys = get_post_custom_keys( $post_id );
            switch ( $column ) {
                case 'applicant' :
                    $applicant_name = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array ( 'post' => $post_id, 'action' => 'edit' ), 'post.php' ) ), esc_html( get_post_meta( $post_id, $keys[ 0 ], TRUE ) )
                    );
                    echo $applicant_name;
                    break;
                case 'taxonomy' :
                    $parent_id = wp_get_post_parent_id( $post_id ); // get_post_field ( 'post_parent', $post_id );
                    $terms = get_the_terms( $parent_id, 'aol_ad_category' );
                    if ( ! empty( $terms ) ) {
                        $out = array ();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array ( 'post_type' => get_post_type( $parent_id ), 'aol_ad_category' => $term->slug ), 'edit.php' ) ), esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'jobpost_category', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    }/* If no terms were found, output a default message. */ else {
                        _e( 'No Categories' , 'apply-online');
                    }
                    break;
            }
        }                
    
        public function aol_post_row_actions($actions, $post){
            if($post->post_type == 'aol_application'){
                return null;
            }
            elseif($post->post_type == 'aol_ad'){
                $actions['test'] = '<a rel="permalink" title="View All Applications" href="'.  admin_url('edit.php?post_type=aol_application').'&ad='.$post->ID.'">Applications</a>';
                return $actions;
            }
        }
        
        public function applications_filter( $query ) {
            if ( $query->is_main_query() AND is_admin() AND isset($_GET['ad'])) {
                $query->set( 'post_parent', $_GET['ad'] );
            }
        }
        
        public function application_print(){
            if(isset($_GET['page']) and $_GET['page'] == 'aol_print' ){
                $post = get_post($_GET['id']);
                $parent = get_post($post->post_parent);
                ?>
                <!DOCTYPE html>
                <html lang="en-US">
                <head>
                    <meta charset="UTF-8">
                    <title>Application <?php echo $_GET['id']; ?> - Apply online</title>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta name="robots" content="noindex,nofollow">

                    <link rel='stylesheet' id='open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=4.7.5' type='text/css' media='all' />
                    <link rel='stylesheet' id='single-style-css'  href='<?php echo plugin_dir_url(__FILE__); ?>css/print.css?ver=<?php echo $this->version; ?>' type='text/css' media='all' />
                </head> 
                <body class="body wpinv print">
                    <div class="row top-bar no-print">
                        <div class="container">
                            <div class="col-xs-6">
                                <a class="btn btn-primary btn-sm" onclick="window.print();" href="javascript:void(0)">Print Application</a>
                            </div>
                        </div>
                    </div>
                    <div class="container wrap">
                        <htmlpageheader name="pdf-header">
                            <div class="row header">
                                <div class="col-xs-6 business">
                                    <a target="_blank" href="<?php bloginfo('url'); ?>"><h1><?php bloginfo('name'); ?></h1></a>
                                </div>

                                <div class="col-xs-6 title">
                                    <h2>Application</h2>
                                </div>
                            </div>
                        </htmlpageheader>
                        <div class="row top-content">
                            
                            <div class="col-xs-12 col-sm-6 details">
                                <div class="col-xs-12 line-details">
                                    <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th><?php _e('Application ID', 'apply-online'); ?></th>
                                            <td><?php echo $_GET['id']; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php _e('Application for', 'apply-online'); ?></th>
                                            <td><?php echo $parent->post_title; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Received on</th>
                                            <td><?php echo $post->post_date; ?><br />( <?php echo $post->post_date_gmt; ?> GMT )</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <table class="table table-sm table-bordered table-responsive">
                            <tbody><?php 
                                        $keys = get_post_custom_keys($_GET['id']); 
                                        foreach ( $keys as $key ):
                                        if ( substr ( $key, 0, 9 ) == '_aol_app_' ) {

                                            $val = get_post_meta ( $post->ID, $key, true ); //Escaping output.
                                            if(is_array($val)) $val = implode(', ', $val);
                                            $val = esc_textarea($val);

                                            if (!filter_var($val, FILTER_VALIDATE_URL) === false) $val = '<a href="'.$val.'" target="_blank">Attachment</a>';

                                            echo '<tr><td>' . str_replace ( '_', ' ', substr ( $key, 9 ) ) . '</td><td>' . $val . '</td></tr>';
                                        }
                                    endforeach;
                                    ?>
                            </tbody>
                        </table>
                        <htmlpagefooter name="wpinv-pdf-footer">
                            <div class="row wpinv-footer">
                                <div class="col-sm-12">
                                    <div class="footer-text"><a target="_blank" href="<?php bloginfo('url') ?>"><?php bloginfo('url'); ?></a></div>
                                </div>
                            </div>
                    </htmlpagefooter>
                    </div>
                </body>
                </html>
            <?php die();
            }
        }
        
        /**
         * Creates Detail Page for Applicants
         * 
         * 
         * @access  public
         * @since   1.0.0
         * @return  void
         */
        public function aol_application_post_editor (){
            global $post;
            if ( !empty ( $post ) and $post->post_type =='aol_application' ):
                $keys = get_post_custom_keys ( $post->ID );
                ?>
                <div class="wrap"><div id="icon-tools" class="icon32"></div>
                    <h3><?php the_title(); ?></h3>
                    <h3>
                        <?php 
                        // _aol_attachment feature has obsolete since version 1.4, It is now treated as Post Meta.
                        if ( in_array ( '_aol_attachment', $keys ) ):
                            $files = get_post_meta ( $post->ID, '_aol_attachment', true );
                            ?>
                        &nbsp; &nbsp; <small><a href="<?php echo esc_url(get_post_meta ( $post->ID, '_aol_attachment', true )); ?>" target="_blank" ><?php echo __( 'Attachment' , 'apply-online' );?></a></small>
                        <?php endif; ?>

                    </h3>
                    <table class="widefat striped">
                        <?php
                        foreach ( $keys as $key ):
                            if ( substr ( $key, 0, 9 ) == '_aol_app_' ) {

                                $val = get_post_meta ( $post->ID, $key, true ); //Escaping output.
                                if(is_array($val)) $val = implode(', ', $val);
                                $val = esc_textarea($val);
                                
                                if (!filter_var($val, FILTER_VALIDATE_URL) === false) $val = '<a href="'.$val.'" target="_blank">Attachment</a>';

                                echo '<tr><td>' . str_replace ( '_', ' ', substr ( $key, 9 ) ) . '</td><td>' . $val . '</td></tr>';
                            }
                        endforeach;
                        ?>
                    </table>
                </div>
                <h3><?php echo __( 'Notes' , 'apply-online' );?></h3>
                <?php
            endif;
        }        
    }

  /**
  * This class adds Meta Boxes to the Edit Screen of the Ads.
  * 
  * 
  * @since      1.0
  * @package    MetaBoxes
  * @subpackage MetaBoxes/includes
  * @author     Farhan Noor
  **/
 class Applyonline_MetaBoxes{
     
        /**
	 * Application Form Field Types.
	 *
	 * @since    1.3
	 * @access   public
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
        var $app_field_types;
             
        public function __construct() {
            add_action('aol_schedule_event', array($this, 'close_ad')); //keep this cron hook claing at top.
            $this->app_field_types = array('text'=>'Text Field', 'email'=>'E Mail', 'text_area'=>'Text Area', 'date'=>'Date', 'checkbox'=>'Check Box', 'dropdown'=>'Drop Down', 'radio'=> 'Radio', 'file'=>'File');
            add_action( 'add_meta_boxes', array($this, 'aol_meta_boxes'),1,1 );
            add_action( 'save_post', array( $this, 'save_metas' ) );
            add_action('do_meta_boxes', array($this, 'alter_metaboxes_on_application_page'));
            add_action( 'admin_enqueue_scripts', array($this, 'enqueue_date_picker') );
        }
        
        function close_ad($post_id){
            update_post_meta($post_id, '_aol_closed', 0);
        }
                
        function enqueue_date_picker(){
                wp_enqueue_script( 'jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
        }
        
        public function alter_metaboxes_on_application_page(){
            remove_meta_box('commentstatusdiv', 'aol_application', 'normal'); //Hide discussion meta box.
        }
        
        /**
	 * Metaboxes for Ads Editor
	 *
	 * @since     1.0
	 */
        function aol_meta_boxes($post) {

            add_meta_box(
                'aol_ad_metas',
                __( 'Ad Features', 'apply-online' ),
                array($this, 'ad_features'),
                'aol_ad',
                'advanced',
                'high'
            );

            add_meta_box(
                'aol_ad_app_fields',
                __( 'Application Form Fields', 'apply-online' ),
                array($this, 'application_form_fields'),
                'aol_ad',
                'advanced',
                'high'
            );
            
            add_meta_box(
                'aol_meta',
                __( 'Apply Online', 'apply-online' ),
                array($this, 'aol_meta'),
                'aol_ad',
                'side'
            );
            
            add_meta_box(
                'aol_application',
                __( 'Application Details', 'apply-online' ),
                array($this, 'application_general'),
                'aol_application',
                'side'
            );
        }
        
        function application_general(){
            global $post;
            echo '<a href="'.admin_url().'?page=aol_print&id='.$post->ID.'" class="button button-secondary button-large" target="_blank">Print Application</a>';
        }
        
        /*
         * Generates shortcode and php code for the form.
         */
        function aol_meta(){
            echo '<p>Full ad shortcode<code>[aol_ad id="'.  get_the_ID().'"]</code></p>';
            echo '<p>Form shortcode <code>[aol_form id="'.  get_the_ID().'"]</code></p>';
            do_action('aol_metabox_end');
        }
        
        function ad_features( $post ) {

            // Add a nonce field so we can check for it later.
                wp_nonce_field( 'myplugin_adpost_meta_awesome_box', 'adpost_meta_box_nonce' );

                /*
                 * Use get_post_meta() to retrieve an existing value
                 * from the database and use the value for the form.
                 */
            ?>
            <div class="ad_features adpost_fields">
                <ol id="ad_features">
                    <?php
                        $keys = get_post_custom_keys( $post->ID);
                        if($keys != NULL):
                            foreach($keys as $key):
                                if(substr($key, 0, 13)=='_aol_feature_'){
                                    $val=get_post_meta($post->ID, $key, TRUE);
                                    echo '<li><label for="'.$key.'">';
                                    _e( str_replace('_',' ',substr($key,13)), 'apply-online' );
                                    echo '</label> ';
                                    echo '<input type="text" id="'.$key.'" name="'.$key.'" value="' . esc_attr( $val ) . '" /> &nbsp; <div class="button removeField">Delete</div></li>';
                                }
                            endforeach;
                        endif;
                    ?>
                </ol>
            </div>
            <div class="clearfix clear"></div>
            <table id="adfeatures_form" class="alignleft">
            <thead>
                <tr>
                    <th class="left"><label for="adfeature_name">Feature</label></th>
                    <th><label for="adfeature_value">Value</label></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" id="adFeature">
                        <input type="text" id="adfeature_name" />
                    </td><td>
                        <input type="text" id="adfeature_value" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class=""><div class="button" id="addFeature">Add Feature</div></div>
                    </td>
                </tr>
            </tbody>
            </table>
            <div class="clearfix clear"></div>
            <?php 
        }
        
        public function application_fields_generator($app_fields){

            ?>
            <div class="clearfix clear"></div>
            <table id="adapp_form_fields" class="alignleft">
            <thead>
                <tr>
                    <th class="left"><label for="metakeyselect">Field</label></th>
                    <th><label for="metavalue">Type</label></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" id="newmetaleft">
                        <input type="text" id="adapp_name" />
                    </td><td>
                        <select id="adapp_field_type">
                            <?php
                                foreach($app_fields as $key => $val):
                                    echo '<option value="'.$key.'" class="'.$key.'">'.$val.'</option>';
                                endforeach;
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" ><input id="adapp_field_options" class="adapp_field_type" type="text" style="display: none;" placeholder="Option1, Option2, Option3" ></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class=""><div class="button" id="addField">Add Field</div></div>
                    </td>
                </tr>
            </tbody>
            </table>
            <div class="clearfix clear"></div>
        <?php
        }
        
        public function application_form_fields( $post ) {
            //@todo:    Make application fields editable or Moveable.
            //
            //global $adfields;
            // Add a nonce field so we can check for it later.
            wp_nonce_field( 'myplugin_adpost_meta_awesome_box', 'adpost_meta_box_nonce' );

            /*
             * Use get_post_meta() to retrieve an existing value
             * from the database and use the value for the form.
             */
            ?>
            <div class="app_form_fields adpost_fields">
                <table>
                <tbody id="app_form_fields">
                    <?php 
                    $fields = array();
                    if(isset($_GET['post'])){ 
                        //Fetch Feilds keys order
                        $fields = get_aol_ad_post_meta($post->ID);
                    }
                    else{
                            $fields = get_option('aol_default_fields', array());
                        } 
                            foreach($fields as $key => $val):
                                    if(!isset($val['required'])) $val['required'] = 1;
                                    $req_class = ($val['required'] == 0) ? 'button-disabled': null;
                                    $fields = NULL;
                                    foreach($this->app_field_types as $field_key => $field_val){
                                        if($val['type']==$field_key) $fields .= '<option value="'.$field_key.'" selected>'.$field_val.'</option>';
                                        else $fields .= '<option value="'.$field_key.'" >'.$field_val.'</option>';
                                    }               
                                    
                                    //if($key.'[type]'=='text'){
                                        echo '<tr data-id="'.$key.'" class="'.$key.'">';
                                        echo '<td><label for="'.$key.'"><span class="dashicons dashicons-menu"></span> '.str_replace('_',' ',substr($key,9)).'</label></td>';
                                        echo '<td>';
                                        echo '<input type="hidden" name="'.$key.'[required]" value="'.($val['required']).'" /><div class="button-primary '.$req_class.' toggle-required">Required</div> ';
                                        echo '<select class="adapp_field_type" name="'.$key.'[type]">'.$fields.'</select>';
                                        //if(!($val['type']=='text' or $val['type']=='email' or $val['type']=='date' or $val['type']=='text_area' or $val['type']=='file' )):
                                        if(in_array($val['type'], array('checkbox','dropdown','radio',))):
                                            echo '<input type="text" name="'.$key.'[options]" value="'.$val['options'].'" placeholder="Option1, option2, option3,......" />';
                                        else:
                                            echo '<input type="text" name="'.$key.'[options]" placeholder="Option1, option2, option3" style="display:none;"  />';
                                        endif;
                                        echo ' &nbsp; <div class="button removeField">Delete</div>';
                                        echo '</td></tr>';
                                    //}
                            endforeach;
                    ?>
                </tbody></table>
            </div>  
            

            <?php
            $this->application_fields_generator($this->app_field_types);
        }     
        
        /**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
        function save_metas( $post_id ) {

            /*
             * We need to verify this came from our screen and with proper authorization,
             * because the save_post action can be triggered at other times.
             */

            // Check if our nonce is set.
            if ( ! isset( $_POST['adpost_meta_box_nonce'] ) ) {
                    return;
            }

            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $_POST['adpost_meta_box_nonce'], 'myplugin_adpost_meta_awesome_box' ) ) {
                    return;
            }

            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                    return;
            }

            // Check the user's permissions.
            if ( isset( $_POST['post_type'] ) && 'aol_ad' == $_POST['post_type'] ) {
                    if ( ! current_user_can( 'edit_post', $post_id ) ) {
                            return;
                    }
            }

            /* OK, it's safe for us to save the data now. */

            //Delete fields.
            $old_keys = get_post_custom_keys($post_id);
            $new_keys = array_keys($_POST);
            $removed_keys = array_diff($old_keys, $new_keys); //List of removed meta keys.
            foreach($removed_keys as $key => $val):
                if(substr($val, 0, 4) == '_aol') delete_post_meta($post_id, $val); //Remove meta from the db.
            endforeach;
            
            // Add/update new value.
            $fields_order = array();
            foreach ($_POST as $key => $val):
                // Make sure that it is set.
                if ( substr($key, 0, 13)=='_aol_feature_' and isset( $val ) ) {
                    //Sanitize user input.
                    $my_data = sanitize_text_field( $val );
                    update_post_meta( $post_id, $key,  $my_data); // Add new value.
                }
                // Make sure that it is set.
                elseif ( substr($key, 0, 9) == '_aol_app_' and isset( $val ) ) {
                    //$my_data = serialize($val);
                    update_post_meta( $post_id, $key,  $val); // Add new value.
                    $fields_order[] = $key;
                }
                // 
            endforeach;
            update_post_meta( $post_id, '_aol_fields_order',  $fields_order); // Add new value.
        }
}

  /**
  * This class contains all nuts and bolts of plugin settings.
  * 
  * 
  * @since      1.3
  * @package    Applyonline_settings
  * @author     Farhan Noor
  **/
class Applyonline_Settings extends Applyonline_MetaBoxes{
    
    private $version;

    public function __construct($version) {
        
        parent::__construct(); //Acitvating Parent's constructor
        
        $this->version = $version;
        
        //Registering Submenus.
        add_action('admin_menu', array($this, 'sub_menus'));
        
        //Registering Settings.
        add_action( 'admin_init', array($this, 'registers_settings') );
    }


    public function sub_menus(){
        add_submenu_page( 'edit.php?post_type=aol_ad', __('AOL Settings', 'apply-online'), __('Settings', 'apply-online'), 'manage_options', 'settings', array($this, 'settings_page_callback') );
    }

    public function settings_page_callback(){
        if ( !empty( $_POST['aol_default_app_fields'] ) && check_admin_referer( 'aol_awesome_pretty_nonce','aol_default_app_fields' ) ) {
            //Remove unnecessary fields
            foreach($_POST as $key => $val){
                if(substr($key, 0, 4) != '_aol') unset($_POST[$key]);
            }
            
            //Save aol default fields in DB.
            update_option('aol_default_fields', $_POST);
        }
        $tabs = $tabs = json_decode(json_encode($this->settings_api()), FALSE);
        ob_start();
        ?>
            <div class="wrap aol-settings">
                <h2>Apply Online <small class="wp-caption alignright"><i>version <?php echo $this->version; ?></i></small></h2>
                <h2 class="nav-tab-wrapper">
                    <?php 
                        foreach($tabs as $tab){
                            empty($tab->href) ? $href = null : $href = 'href="'.$tab->href.'" target="_blank"';
                            isset($tab->classes) ? $classes = $tab->classes : $classes = null;
                            echo '<a class="nav-tab '.$classes.'" data-id="'.$tab->id.'" '.$href.'>'.$tab->name.'</a>';
                        }
                    ?>
                </h2>
                <?php 
                    foreach($tabs as $tab){
                        $func = 'tab_'.$tab->id;
                        echo '<div class="tab-data wrap" id="'.$tab->id.'">';
                        if(isset($tab->desc)) echo '<h3>'.$tab->desc.'</h3>';
                        
                        echo isset($tab->output) ? $tab->output : $this->$func(); //Return $output or related method of the same variable name.
                        echo '</div>';
                    }
                ?>
            </div>
            <style>
                h3{margin-bottom: 5px;}
                .nav-tab{cursor: pointer}
                .tab-data{display: none;}
            </style>
        <?php
        return ob_get_flush();
    }           

    public function registers_settings(){
        register_setting( 'aol_settings_group', 'aol_recipients_emails' );
        register_setting( 'aol_settings_group', 'aol_application_message' );
        register_setting( 'aol_settings_group', 'aol_required_fields_notice');
        register_setting( 'aol_settings_group', 'aol_thankyou_page' );
        register_setting( 'aol_settings_group', 'aol_slug', 'sanitize_title' ); 
        register_setting( 'aol_settings_group', 'aol_upload_max_size', 'floatval' );
        register_setting( 'aol_settings_group', 'aol_upload_folder','sanitize_text_field' );
        register_setting( 'aol_settings_group', 'aol_allowed_file_types','sanitize_text_field' );
        
        //On update of aol_slug field, update permalink too.
        add_action('update_option_aol_slug', array($this, 'refresh_permalink'));
    }
    
    public function refresh_permalink(){
        //Re register post type for proper Flush Rules.
        $slug = get_option('aol_slug', 'ads');
        if(empty($slug)) $slug = 'ads';
        /*Register Main Post Type*/
        register_post_type('aol_ad', array('has_archive' => true, 'rewrite' => array('slug'=>  $slug)));
        
        flush_rewrite_rules();
    }
    
    function settings_api(){
        $tabs = array(
                'general' => array(
                    'id'        => 'general',
                    'name'      => __( 'General' ,'apply-online' ),
                    'desc'      => __( 'General settings of the plugin', 'apply-online' ),
                    'href'      => null,
                    'classes'     => 'nav-tab-active',
                ),
                'defaults' => array(
                    'id'        => 'defaults',
                    'name'      => __('Defaults' ,'apply-online'),
                    'desc'      => __( 'Application form default fields', 'apply-online' ),
                    'href'      => null,
                ),
        );
        $tabs = apply_filters('aol_settings_tabs', $tabs);
        $tabs['faqs'] = array(
                    'id'        => 'faqs',
                    'name'      => __('FAQs' ,'apply-online'),
                    'desc'      => __('Frequently Asked Questions' ,'apply-online'),
                    'href'      => null,
                );
        $tabs['extend'] = array(
                    'id'        => 'extend',
                    'name'      => __('Extend' ,'apply-online'),
                    'desc'      => __('Extend Plugin' ,'apply-online'),
                    'href'      => 'http://wpreloaded.com/plugins/apply-online',
                );
        return $tabs;
    }
    
    private function wp_pages(){
        $pages = get_pages();
        $pages_arr = array();
        foreach ( $pages as $page ) {
            $pages_arr[$page->ID] = $page->post_title;
        }
        return $pages_arr;
    }
    
    private function tab_general(){
        ?>
            <form action="options.php" method="post" name="">
                <table class="form-table">
                <?php
                    settings_fields( 'aol_settings_group' ); 
                    do_settings_sections( 'aol_settings_group' );
                    
                ?>
                    <tr>
                        <th><label for="aol_recipients_emails"><?php _e('List of e-mails to get application alerts', 'apply-online'); ?></label></th>
                        <td><textarea id="aol_recipients_emails" class="small-text code" name="aol_recipients_emails" cols="50" rows="5"><?php echo esc_attr( get_option('aol_recipients_emails') ); ?></textarea><p class="description">Just one email id in one line.</p></td>
                    </tr>
                    <tr>
                        <th><label for="aol_required_fields_notice"><?php _e('Required form fields notice', 'apply-online'); ?></label></th>
                        <td>
                            <textarea class="small-text code" name="aol_required_fields_notice" cols="50" rows="3" id="aol_required_fields_notice"><?php echo esc_attr( get_option('aol_required_fields_notice', __('Fields with (*)  are compulsory.', 'apply-online')) ); ?></textarea>
                            <br />
                            <button class="button" id="aol_required_fields_button"><?php _e('Default Notice', 'apply-online'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="aol_date_format"><?php _e('Date format for date fields', 'apply-online'); ?></label></th>
                        <td>
                            <p>Update time format/zone on Wordpress <a href="<?php echo admin_url('options-general.php#timezone_string'); ?>" target="_blank" />General Settings</a> Page.</p>
                        </td>
                    </tr>                    
                    <tr>
                        <th><label for="aol_application_message"><?php _e('Application submission message', 'apply-online'); ?></label></th>
                        <td>
                            <textarea id="aol_application_message" class="small-text code" name="aol_application_message" cols="50" rows="3"><?php echo esc_attr( get_option('aol_application_message', __('Form has been submitted successfully. We will get back to you very soon.', 'apply-online')) ); ?></textarea>
                            <br />
                            <button id="aol_submission_default" class="button"><?php _e('Default Message', 'apply-online'); ?></button>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="thanks-page"><?php _e('Thank you page', 'apply-online'); ?></label></th>
                        <td>
                            <select id="thank-page" name="aol_thankyou_page">
                                <option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option> 
                                <?php 
                                $selected = get_option('aol_thankyou_page');

                                 $pages = get_pages();
                                 foreach ( $pages as $page ) {
                                     $attr = null;
                                     if($selected == $page->ID) $attr = 'selected';

                                       $option = '<option value="' . $page->ID . '" '.$attr.'>';
                                       $option .= $page->post_title;
                                       $option .= '</option>';
                                       echo $option;
                                 }
                                ?>
                           </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="aol_slug"><?php _e('Ads slug', 'apply-online'); ?></label></th>
                        <td>
                            <input id="aol_slug" type="text" class="regular-text" name="aol_slug" placeholder="ads" value="<?php echo esc_attr( get_option('aol_slug', 'ads') ); ?>" />
                            <p class="description"><?php _e('Default permalink is ', 'apply-online'); bloginfo('url'); ?>/<b>ads</b>/</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="aol_form_max_file_size"><?php _e('Max file attachment size', 'apply-online'); ?></label></th>
                        <td>
                            <input id="aol_form_max_upload_size" type="number" name="aol_upload_max_size" placeholder="1" value="<?php echo esc_attr( get_option('aol_upload_max_size', 1) ); ?>" />MBs
                            <p class="description"><?php _e('Max limit by server is ', 'apply-online'); ?><?php echo floor(wp_max_upload_size()/1000000); ?> MBs</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="aol_allowed_file_types"><?php _e('Allowed file types', 'apply-online'); ?></label></th>
                        <td>
                            <textarea id="aol_allowed_file_types" name="aol_allowed_file_types" class="code" placeholder="jpg,jpeg,png,doc,docx,pdf,rtf,odt,txt" cols="50" rows="2"><?php echo esc_textarea(get_option('aol_allowed_file_types', 'jpg,jpeg,png,doc,docx,pdf,rtf,odt,txt')); ?></textarea>
                            <p class="description"><?php _e('Comma separated names of file extentions. Default: ', 'apply-online'); ?>jpg,jpeg,png,doc,docx,pdf,rtf,odt,txt</p>
                        </td>
                    </tr>
                    <?php 
                        //$general = apply_filters('general_settings', $general); 
                    ?>
                </table>
                <?php submit_button(); ?>
            </form>
            <?php 
    }
    
    private  function tab_defaults(){
        ?>
        <form id="template_form" method="post">
            <div class="app_form_fields adpost_fields">
                <ol id="app_form_fields">
                    <?php 
                        $app_fields = $this->app_field_types;
                        settings_fields( 'aol_application_template' );
                        do_settings_sections( 'aol_application_template' );

                        $keys= get_option('aol_default_fields');
                        if($keys != NULL):
                            foreach($keys as $key => $val):
                                if(substr($key, 0, 9)=='_aol_app_'):

                                    $fields = NULL;
                                    foreach($app_fields as $field_key => $field_val){
                                        if($val['type']==$field_key) $fields .= '<option value="'.$field_key.'" selected>'.$field_val.'</option>';
                                        else $fields .= '<option value="'.$field_key.'" >'.$field_val.'</option>';
                                    }
                                    //if($key.'[type]'=='text'){
                                        echo '<li class="'.$key.'"><label for="'.$key.'">'.str_replace('_',' ',substr($key,9)).'</label><select class="adapp_field_type" name="'.$key.'[type]">'.$fields.'</select>';
                                        if(!($val['type']=='text' or $val['type']=='email' or $val['type']=='date' or $val['type']=='text_area' or $val['type']=='file')):
                                            echo '<input type="text" name="'.$key.'[options]" value="'.$val['options'].'" placeholder="Option1, option2, option3" />';
                                        else:
                                            echo '<input type="text" name="'.$key.'[options]" placeholder="Option1, option2, option3" style="display:none;"  />';
                                        endif;
                                        echo ' &nbsp; <div class="button removeField">Delete</div></li>';
                                    //}
                                endif;
                            endforeach;
                        endif;
                    ?>
                </ol>
            </div>  
            <?php $this->application_fields_generator($this->app_field_types); ?>
            <hr />
            <?php submit_button(); ?>
            <?php wp_nonce_field( 'aol_awesome_pretty_nonce','aol_default_app_fields' ); ?>
        </form>            
        <?php
    }
    
    private function tab_faqs(){
        $slug = get_option('aol_slug', 'ads');
        if(empty($slug)) $slug = 'ads';
        ?>
        <div class="card" style="max-width:100%">
            <h3><?php echo __('How to create an ad?' ,'apply-online') ?></h3>
            In your WordPress admin panel, go to "Apply Online" menu and add a new ad listing.

            <h3>How to show ad listings on the front-end?</h3>
            <!-- @todo Fix empty return value of aol_slug option. !-->
            <ol>
                <li>The url <b><a href="<?php echo get_bloginfo('url').'/'.  $slug; ?>" target="_blank" ><?php echo get_bloginfo('url').'/'. $slug; ?></a></b> lists all the applications using your theme's default look and feel.<br />
                    &nbsp; &nbsp;&nbsp;(If above not working, try saving <a href="<?php echo get_admin_url().'/options-permalink.php'; ?>"  >permalinks</a> without any change)</li>
                <li>Write [aol] shortcode in an existing page or add a new page and write shortcode anywhere in the page editor. Now click on VIEW to see all of your ads on front-end.
                    <br /> <i>Listing ads using [aol] shortcode will not display pagination !</i></li>
            </ol>

            <h3>Can I show few adds on front-end?</h3>
            Yes, you can show any number of ads on your website by using shortcode with "ads" attribute. Ad ids must be separated with commas i.e. [aol ads="1,2,3"].

            <h3>Can I show ads from particular category only?</h3>
            Yes, you can show ads from any category / categories using "categories" attribute. Categories' ids must be separated with commas i.e. [aol categories="1,2,3"].

            <h3>Can I show ads without excerpt/summary?</h3>
            Yes, use shortcode with "excerpt" attribute i.e. [aol excerpt="no"]

            <h3>What attributes can i use in the shortcode?</h3>
            Default shortcode with all attributes is [aol categories="1,2,3" ads="1,2,3" excerpt="no"]. Use only required attributes.

            <h3>How can i get the id of a category or ad?</h3>
            In admin panel, move your mouse pointer on an item in categories or ads table. Now you can view item ID in the info bar of the browser.

            <h3>Can i display application form only using shortocode?</h3>
            Yes, [aol_form id="0"] is the shortcode to display a particular application form in wordpress pages or posts. Use correct form id in the shortocode.
        </div>    
        <?php
    }
    
    private function tab_extend(){
        ?>
        <div class="card" style="max-width:100%">
            <a href="http://wpreloaded.com/plugins/apply-online" target="_blank">Click Here</a> for docs and addons. 
        </div>            
        <?php 
    }
 }
 
 function get_aol_option($option){
     $options = get_option('aol_options');
     $val = isset($options[$option]) ? $options[$option] : null;
     return $val;
 }