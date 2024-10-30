<?php
/*plugin initialization*/
function initLoginCustomActive(){}
function initLoginCustomDective(){}
if(!class_exists('loginCustomInit')){
	class loginCustomInit
	{
		function __construct()
		{
			$this->lcInit();
		}

		public function lcInit()
		{
			add_action('admin_menu', array($this,'activeLcMenu'));
			add_action('wp_enqueue_scripts',array($this,'lc_front_enque_scripts')); // Enqueue scripts
		    add_action('admin_enqueue_scripts',array($this,'lc_admin_enque_scripts')); // Enqueue scripts

		    /*	If the url active check the template and enqueue script and style  */

		    $lc_key = '';
			$lc_key = sanitize_option('lc_url_key', get_option('lc_url_key'));
			if(sanitize_option('lc_url_key', get_option('lc_url_key')))
			{
				global $wpdb;
				$post_tbl = $wpdb->prefix.'posts';
				$lc_post = $wpdb->get_row( "SELECT * FROM ".$post_tbl." WHERE `post_name`='".$lc_key."'" );

				$lc_postid = intval($lc_post->ID);


			    if(get_post_meta( $lc_postid, '_wp_page_template', TRUE ) == 'template-firstlog.php')
			    {
			    	add_action('wp_enqueue_scripts',array($this,'lc_front_enque_scripts_first')); // Enqueue scripts
			    }

			    if(get_post_meta( $lc_postid, '_wp_page_template', TRUE ) == 'template-secondlog.php')
			    {
			    	add_action('wp_enqueue_scripts',array($this,'lc_front_enque_scripts_second')); // Enqueue scripts
			    }
			}
			

			/* plugin status change to active */
		    add_action( 'wp_ajax_get_lc_status',  array($this,'get_lc_status_callback') );
	    	add_action( 'wp_ajax_nopriv_get_lc_status',  array($this,'get_lc_status_callback') );

	    	/* plugin save generated URL */
	    	add_action( 'wp_ajax_get_lc_url_save',  array($this,'get_lc_url_save_callback') );
	    	add_action( 'wp_ajax_nopriv_get_lc_url_save',  array($this,'get_lc_url_save_callback') );

	    	/* plugin status change to diactive */
	    	add_action( 'wp_ajax_get_lc_disable',  array($this,'get_lc_disable_callback') );
	    	add_action( 'wp_ajax_nopriv_get_lc_disable',  array($this,'get_lc_disable_callback') );

	    	/* plugin save template to select login page template */
	    	add_action( 'wp_ajax_get_lc_template_save',  array($this,'get_lc_template_save_callback') );
	    	add_action( 'wp_ajax_nopriv_get_lc_template_save',  array($this,'get_lc_template_save_callback') );
	    	
	    	/*  By enable this plugin option disable wp-login.php and wp-admin in url */
	    	if(get_option('lc_url_status') == 'enable')
	    	{
	    		add_action('login_form',  array($this,'redirect_wp_admin')); //working

	    		add_action('login_redirect',  array($this, 'lc_custom_login')); //working

	    		add_action('wp_login_failed', array($this, 'lc_custom_login_fail'));

	    		add_action('logout_redirect',  array($this, 'lc_custom_logout'));

				
				add_filter ('theme_page_templates', array($this,'lc_add_page_template'));

		    	add_filter ('template_include', array($this,'lc_redirect_page_template'));
	    		
				add_action( 'admin_head', array($this,'lc_remove_dispaly_page') );
				
	    		
	    	}
		}

		/* add admin menu */
		public function activeLcMenu()
		{
			add_menu_page( 
		        __( 'MM Login Customization', 'textdomain' ),
		        'MM Login Customization',
		        'manage_options',
		        'lc-setting',
		        array($this,'lcSettingFn'),
		        plugins_url( 'mm-login-customization/assets/images/back/lc-icon.png' ),
		        6
		      ); 

		    add_submenu_page('lc-setting', '', 'Settings', 'manage_options', 'lc-setting' );

		    add_submenu_page(
		      'lc-setting',
		        __( 'Help', 'textdomain' ),
		        __( 'Help', 'textdomain' ),
		        'manage_options',
		        'lc-setting-help',
		        array($this,'lcSettingHelpCallback')
		    );
		}

		/* plugin admin enqueue script */
		public function lc_admin_enque_scripts()
		{
			wp_register_style( 'back_lc_style', MMLC_CSS_BACK.'/mmlc_admin_style.css');
		    wp_enqueue_style( 'back_lc_style' );

		    wp_enqueue_script('back_lc_script', MMLC_JS_BACK.'/mmlc_admin_ajax.js',array('jquery'),'1.0.0',true);

		    wp_localize_script('back_lc_script','lc_admin_localize_ajax_url',array(
		      'admin_url'         => admin_url().'admin-ajax.php'
		    ));
		}

		/* plugin front end enqueue script */
		public function lc_front_enque_scripts()
		{
			wp_register_style( 'back_lc_style', MMLC_CSS_FRONT.'/mmlc_front_style.css');
		    wp_enqueue_style( 'back_lc_style' );

		    wp_enqueue_script('back_lc_script', MMLC_JS_FRONT.'/mmlc_front_ajax.js',array('jquery'),'1.0.0',true);

		    wp_localize_script('back_lc_script','lc_front_localize_ajax_url',array(
		      'admin_url'         => admin_url().'admin-ajax.php'
		    ));
		}

		/* First template scrip and style add */
		public function lc_front_enque_scripts_first()
		{
			wp_register_style( 'front_lc_one_style', MMLC_CSS_FRONT.'/mmlc_front_tempate_one_style.css');
		    wp_enqueue_style( 'front_lc_one_style' );
		}

		/* Second template scrip and style add */
		public function lc_front_enque_scripts_second()
		{
			wp_register_style( 'front_lc_two_style', MMLC_CSS_FRONT.'/mmlc_front_tempate_two_style.css');
		    wp_enqueue_style( 'front_lc_two_style' );
		}

		public function lcSettingFn()
		{
			$lcsettingObj = new lcAdminSettings();
			$lcsettingObj->lcAdminSetup();
		}

		public function get_lc_status_callback()
		{
			$lcstatusObj = new lcAdminSettingsStatus();
			$lcstatusObj->lcAdminStatusSetup();
			die();
		}

		public function get_lc_url_save_callback()
		{
			$lcurlSaveObj = new lcAdminSettingsStatus();
			$lcurlSaveObj->lcAdminStatusUrlSave();
			die();
		}

		public function get_lc_disable_callback()
		{
			$lcurlDisableObj = new lcAdminSettingsStatus();
			$lcurlDisableObj->lcAdminStatusUrlDisable();
			die();
		}

		public function get_lc_template_save_callback()
		{
			$lcTemplateObj = new lcAdminSettingsTemplate();
			$lcTemplateObj->lcTemplateActive();
			die();
		}

		public function lcSettingHelpCallback()
		{
			$lcHelpObj = new lcAdminSettingsHelp();
			$lcHelpObj->lcHelpContent();
			die();
		}

		
	 
		public function redirect_wp_admin(){

		$redirect_to = $_SERVER['REQUEST_URI'];

		 
		 if(count($_REQUEST)> 0 && array_key_exists('redirect_to', $_REQUEST)){
		    $redirect_to = sanitize_text_field($_REQUEST['redirect_to']);
		    $check_wp_admin = stristr($redirect_to, 'wp-admin');
		    
		    if($check_wp_admin){
		    	
		    		wp_safe_redirect( sanitize_file_name('404.php') );
		    		exit;
		    	   
		    }
		 }
	  }


	public function lc_custom_login()
	{
		 global $pagenow;
		 global $user;

		 $requested_uri = $_SERVER["REQUEST_URI"];
		 if( 'wp-login.php' == $pagenow) {
		 	
		 	if((isset($_REQUEST['wp-submit']) and ($_REQUEST['wp-submit'] == 'Log In')) or (isset($_REQUEST['loggedout']) and ($_REQUEST['loggedout'] == 'true')))
		 	{
		 		if ( isset($_REQUEST['wp-submit']) and ($_REQUEST['wp-submit'] == 'Log In') ) {
		    		
					$allowed_roles = array('editor', 'administrator', 'author');

					 if( array_search($user->roles[0],  $allowed_roles) ) {  
					  wp_safe_redirect(site_url().'/wp-admin');
					 } 
		    	}
		    	else
		    	{
		    		wp_safe_redirect(site_url());
		    	}
		 	
		 	}
		 	else
		 	{
		 		wp_safe_redirect( sanitize_file_name('404.php') );
		 	}
		 
	 	}
	}

		/*Include page template from plugin */

	public function lc_add_page_template ($templates) 
	{
			    $templates['template-firstlog.php'] = sanitize_text_field('First Login Template');
			    $templates['template-secondlog.php'] = sanitize_text_field('Second Login Template');
			 
			    return $templates;
	}


	public function lc_redirect_page_template ($template) 
	{

			
		    if(is_page(array(get_option('lc_url_key'))))
			{
				$lckey = '';
				$lckey = sanitize_option('lc_url_key', get_option('lc_url_key'));

				global $wpdb;
				$posttbl = $wpdb->prefix.'posts';
				$lcpost = $wpdb->get_row( "SELECT * FROM ".$posttbl." WHERE `post_name`='".$lckey."'" );

				$lcpostid = $lcpost->ID;
				
			    if (get_post_meta($lcpostid,'_wp_page_template',true) == 'template-firstlog.php')
			    {
			    	$template = plugin_dir_path(__FILE__) . 'front-template/template-firstlog.php';
			    }
			    else
			    {
			    	if (get_post_meta($lcpostid,'_wp_page_template',true) == 'template-secondlog.php')
				    {
				    	$template = plugin_dir_path(__FILE__) . 'front-template/template-secondlog.php';
				    }
			    }
			   
			}
			 locate_template($template);
			 load_template( $template );
		    
	}

		
		
	public function lc_remove_dispaly_page()
	{

				$lckey = '';
				$lckey = sanitize_option('lc_url_key', get_option('lc_url_key'));

				global $wpdb;
				$posttbl = $wpdb->prefix.'posts';
				$lcpost = $wpdb->get_row( "SELECT * FROM ".$posttbl." WHERE `post_name`='".$lckey."'" );

				$lcpostid = intval($lcpost->ID);	        
				?>
		        <style>
		           #post-<?php echo $lcpostid; ?>{
		                display:none;
		           }
		        </style>
		        <?php
		    
	}

	public function lc_custom_login_fail()
	{
			$loginlink = sanitize_text_field(get_option('lc_url_key'));

			wp_safe_redirect(site_url().'/'.$loginlink.'/?login=fail');


	}

	public function lc_custom_logout()
	{
			$loginlink = sanitize_text_field(get_option('lc_url_key'));

			wp_safe_redirect(site_url().'/'.$loginlink);
	}



		
	}new loginCustomInit();
}