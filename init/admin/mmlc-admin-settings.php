<?php
if(!class_exists('lcAdminSettings')){
	class lcAdminSettings
	{
		function __consturuct()
		{

		}

		public function lcAdminSetup()
		{
			$lc_flag_en = 0;

			if(empty(sanitize_option('lc_url_key', get_option('lc_url_key'))))
			{
				$lc_flag_en = 0;
			}
			else
			{
				$lc_flag_en = 1;
			}

			$lcadminhtml = '';
			$lcadminhtml .= '<div id="wpbody" role="main">

								<div id="wpbody-content">';
			$lcadminhtml .= '<div class="wrap">
								<h1 class="wp-heading-inline">MM Login Customization</h1>';
			$lcadminhtml .= '</div><!--wrap-->';

			$lcadminhtml .= '<ul class="lc-admin-tab-link">
								<li id="lc_status_id"><a href="javascript:void(0);" id="lc_status_id_a">Status</a></li>
								<!--<li id="lc_settings_id"><a href="javascript:void(0);" id="lc_settings_id_a">General Settings</a></li>-->';
			if($lc_flag_en == 1)
			{
				$lcadminhtml .= '<li id="lc_template_id"><a href="javascript:void(0);" id="lc_template_id_a">Choose Template</a></li>';
			}
			else
			{
				$lcadminhtml .= '<li id="lc_template_id" style="display: none;"><a href="javascript:void(0);" id="lc_template_id_a">Choose Template</a></li>';
			}
			$lcadminhtml .= '</ul>';

			$lcadminhtml .= '<div class="lcbody">';
			/* Status */
			$lcadminhtml .= '<div id="lc-tab-status">';

			$lcadminhtml .= '<div class="lc-status-msg"></div>';

			

			$lcadminhtml .= '<p class="lc_high"><b>Note : By enable this following option you will get an url for login and wp-login.php will no longer available</b></p>';

			

			if($lc_flag_en == 0)
			{
				$lcadminhtml .= '<div class="lc-onoff">
				<label class="container">
				<input type="radio" name="lcstatus" value="enable">
				<span class="checkmark"></span>Active
				</label>';
				$lcadminhtml .= '<label class="container"><input type="radio" name="lcstatus"   value="disable" checked> <span class="checkmark"></span>Inactive</label></div>';

				$lcadminhtml .= '<div class="lc-det">
								<p class="lc-det-url">After enable the setting you will get the login url here </p>
								<div class="view_lc_url"><p class="lc-url" style="display:none;"></p></div>
							 </div>';
			}
			else
			{
				$lcurl = site_url().'/'.sanitize_option('lc_url_key', get_option('lc_url_key'));
				$lcadminhtml .= '<div class="lc-onoff">
				<label class="container">
				<input type="radio" name="lcstatus" value="enable" checked> 
				<span class="checkmark"></span> Active
				</label>';
				$lcadminhtml .= '<label class="container"><input type="radio" name="lcstatus" value="disable"> <span class="checkmark"></span> Inactive</label></div>';

				$lcadminhtml .= '<div class="lc-det">
								<p class="lc-det-url">Here is your login url: </p>
								<strong><p class="lc-url view_lc_url" id="now_lc_url">'.site_url().'/'.sanitize_option('lc_url_key', get_option('lc_url_key')).'</p></strong>
								<div class="view_lc_url_1" id="lccopy"><p><button class="lccopy_button" onclick="return lc_copy_url(\'#now_lc_url\');">Copy URL</button><p></div>
							 </div>';
			}
			

			$lcadminhtml .= '</div> <!-- lc-tab-status -->';
			/* Status end */


			/* Settings */
			$lcadminhtml .= '<div id="lc-tab-settings">';

			$lcadminhtml .= 'set';

			$lcadminhtml .= '</div><!-- lc-tab-settings -->';
			/* Settings end */

			/* Template */
			$lcadminhtml .= '<div id="lc-tab-template">';
			$lcadminhtml .= '<div class="lc-template" id="lc-template-msg"></div>';

			$lckey = '';

			$lckey = sanitize_option('lc_url_key', get_option('lc_url_key'));
			//if(get_option('lc_url_key'))
			//{
				global $wpdb;
				$posttbl = $wpdb->prefix.'posts';
				$lctemp = $wpdb->get_row( "SELECT * FROM ".$posttbl." WHERE `post_name`='".$lckey."'" );

				

				$lctempid = $lctemp->ID;
				$temp = '';
				$temp = get_post_meta(intval($lctempid),'_wp_page_template',true);

				$temp_no = 0;
				$lcadminhtml .= '<div class="temp_cont">';

				$template_one_url = MMLC_IMG_BACK.'/templc1.png';

				$template_two_url = MMLC_IMG_BACK.'/templc2.png';

				if($temp == 'template-firstlog.php' or $temp == '')
				{
					$temp_no = 1;
					$lcadminhtml .= '<label>
					<input name="lctemplate" value="1" type="radio" class="tem_radio" checked>
					<img src="'.$template_one_url.'" class="temp_lc_img"> 
					<p class="lc_temp_name">Template One</p>
					</label>';
				}
				else
				{
					$lcadminhtml .= '<label><input type="radio" name="lctemplate" class="tem_radio" value="1"><img src="'.$template_one_url.'" class="temp_lc_img"> <p class="lc_temp_name">Template One</p></label>';
				}
				
				if($temp == 'template-secondlog.php')
				{
					$temp_no = 2;
					$lcadminhtml .= '<label><input type="radio" name="lctemplate" class="tem_radio" value="2" checked><img src="'.$template_two_url.'" class="temp_lc_img"> <p class="lc_temp_name">Template Two</p></label>';
				}
				else
				{
					$lcadminhtml .= '<label><input type="radio" name="lctemplate" class="tem_radio" value="2"><img src="'.$template_two_url.'" class="temp_lc_img"> <p class="lc_temp_name">Template Two</p></label>';
				}

				

				$lcadminhtml .= '</div>';

				$lcadminhtml .= '<div class="save_temp_btn"><input type="hidden" name="template_lc" id="template_lc_id" value="'.$temp_no.'" /><a href="javascript:void(0);" onclick="save_lc_template();" class="lccopy_button page-title-action">Save Template</a></div>';
			//}

			$lcadminhtml .= '</div><!-- lc-tab-template -->';

			
			/* Template end */

			$lcadminhtml .= '</div><!--lcbody-->';
								
			$lcadminhtml .= '   </div><!--wpbody-content -->
							</div><!-- wpbody -->';
			echo $lcadminhtml;
		}
	}
}
?>