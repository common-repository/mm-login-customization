<?php
if(!class_exists('lcAdminSettingsStatus')){
	class lcAdminSettingsStatus
	{
		function __construct(){
			$lcadminenq = new loginCustomInit();
			$lcadminenq->lc_admin_enque_scripts();
		}

		/* URL generate */

		public function lcAdminStatusSetup()
		{
			 
			$lcurl = '';
			$lcurlHtml = '';
			$pword = '';

			$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	 
		    $pword = '';
		    for ( $i = 0; $i < 8; $i++ ) {
		        $pword .= substr( $chars, wp_rand( 0, strlen( $chars ) - 1 ), 1 );
		    }

			$lcurl = site_url().'/'.$pword;
			$lcurlHtml .= $lcurl;


			$lcurlHtml .= '<div><input type="hidden" name="hidden_log_url" id="hidden_log_url_id" value="'.sanitize_text_field($pword).'"/>
							<div class="view_lc_disable"><a href="javascript:void(0);" onclick="save_lc_url();" class="lccopy_button page-title-action">Save URL</a> <a href="javascript:void(0);" onclick="referesh_lc_url();" class="lccopy_button page-title-action">Referesh</a></div></div>';
			echo $lcurlHtml;
		}

		/* Save url */
		public function lcAdminStatusUrlSave()
		{
			$lcurl = sanitize_text_field($_POST['lcurl']);
			$lcstatus = sanitize_text_field($_POST['lcstatus']);

			if(empty(sanitize_option('lc_url_key', get_option('lc_url_key'))))
			{
				add_option('lc_url_key', $lcurl);
				add_option('lc_url_status', $lcstatus);

				global $wpdb;
				$posttbl = $wpdb->prefix.'posts';
				$postmetatbl = $wpdb->prefix.'postmeta';
				$lastlcid= '';

				$wpdb->insert($posttbl, array(
				    'post_author' => get_current_user_id(),
				    'post_date' => date("Y-m-d H:i:s"),
				    'post_date_gmt' => date("Y-m-d H:i:s"),
				    'post_content' => '',
				    'post_title' => 'Custom Login',
				    'post_excerpt' => '',
				    'post_status' => 'publish',
				    'comment_status' => 'closed',
				    'ping_status' => 'open',
				    'post_password' => '',
				    'post_name' => $lcurl,
				    'to_ping' => '',
				    'pinged' => '',
				    'post_modified' => date("Y-m-d H:i:s"),
				    'post_modified_gmt' => date("Y-m-d H:i:s"),
				    'post_content_filtered' => '',
				    'post_parent' => 0,
				    'guid' => '',
				    'menu_order' => 0,
				    'post_type' => 'page',
				    'post_mime_type' => '',
				    'comment_count' => 0,

				));

				$lastlcid = intval($wpdb->insert_id);

				$wpdb->update($posttbl, array(
					'guid' => site_url().'/?page_id='.$lastlcid,
				), 
				array('ID'=>$lastlcid));

				$wpdb->insert($postmetatbl, array(
					'post_id' => $lastlcid,
					'meta_key' => '_wp_page_template',
					'meta_value' => 'template-firstlog.php',
				));


			}
			else
			{
				global $wpdb;
				$posttbl = $wpdb->prefix.'posts';
				$postmetatbl = $wpdb->prefix.'postmeta';

				$theprevlog = $wpdb->get_row( "SELECT * FROM ".$posttbl." WHERE `post_name`='".sanitize_option('lc_url_key', get_option('lc_url_key'))."'" );

				$theprevlogid = intval($theprevlog->ID);

				$wpdb->query( "DELETE FROM ".$posttbl." WHERE `post_name`='".sanitize_option('lc_url_key', get_option('lc_url_key'))."'" );

				$wpdb->query( "DELETE FROM ".$postmetatbl." WHERE `post_id`=".$theprevlogid );

				update_option('lc_url_key', $lcurl);
				update_option('lc_url_status', $lcstatus);

				$wpdb->insert($posttbl, array(
				    'post_author' => get_current_user_id(),
				    'post_date' => date("Y-m-d H:i:s"),
				    'post_date_gmt' => date("Y-m-d H:i:s"),
				    'post_content' => '',
				    'post_title' => 'Custom Login',
				    'post_excerpt' => '',
				    'post_status' => 'publish',
				    'comment_status' => 'closed',
				    'ping_status' => 'open',
				    'post_password' => '',
				    'post_name' => $lcurl,
				    'to_ping' => '',
				    'pinged' => '',
				    'post_modified' => date("Y-m-d H:i:s"),
				    'post_modified_gmt' => date("Y-m-d H:i:s"),
				    'post_content_filtered' => '',
				    'post_parent' => 0,
				    'guid' => '',
				    'menu_order' => 0,
				    'post_type' => 'page',
				    'post_mime_type' => '',
				    'comment_count' => 0,

				));

				$lastlcid = $wpdb->insert_id;

				$wpdb->update($posttbl, array(
					'guid' => site_url().'/?page_id='.$lastlcid,
				), 
				array('ID'=>$lastlcid));

				$wpdb->insert($postmetatbl, array(
					'post_id' => $lastlcid,
					'meta_key' => '_wp_page_template',
					'meta_value' => 'template-firstlog.php',
				));
			}

			echo get_option('siteurl').'/'.$lcurl;

		}

		/* Disable link */
		public function lcAdminStatusUrlDisable()
		{
				global $wpdb;
				$posttbl = $wpdb->prefix.'posts';
				$postmetatbl = $wpdb->prefix.'postmeta';

				$theurllog = $wpdb->get_row( "SELECT * FROM ".$posttbl." WHERE `post_name`='".sanitize_option('lc_url_key', get_option('lc_url_key'))."'" );

				$theurllogid = intval($theurllog->ID);

				$wpdb->query( "DELETE FROM ".$posttbl." WHERE `post_name`='".sanitize_option('lc_url_key', get_option('lc_url_key'))."'" );
				
				$wpdb->query( "DELETE FROM ".$postmetatbl." WHERE `post_id`=".$theurllogid );

				delete_option('lc_url_key');
				delete_option('lc_url_status');
		}
	}
}
?>