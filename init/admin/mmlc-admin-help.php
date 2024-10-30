<?php
if(!class_exists('lcAdminSettingsHelp')){
	class lcAdminSettingsHelp
	{
		function __consturuct()
		{

		}

		public function lcHelpContent()
		{

			$lcadminhelphtml = '';
			$lcadminhelphtml .= '<div id="wpbody" role="main">

								<div id="wpbody-content">';
			$lcadminhelphtml .= '<div class="wrap">
									<h1 class="wp-heading-inline">MM Login Customization Help</h1>';
			$lcadminhelphtml .= '</div><!--wrap-->';

			$lcadminhelphtml .= '<div class="lcbody">';

			$lcadminhelphtml .= '<div class="lcbody-help">';

			$lcadminhelphtml .= '<p>1.	Plugins > Install MM Login Customization > Active MM Login Customization</p>';

			$lcadminhelphtml .= '<p>2.	Admin Menu  > MM Login Customization > Settings</p>';

			$lcadminhelphtml .= '<p>3.	Settings > Tab Staus</p>';

			$lcadminhelphtml .= '<p> 	-	From here you can Active and Inactive this plugin.</p>';
			$lcadminhelphtml .= '<p> 	-	If you active the option from status tab and save url from that time wp-admin and wp-login.php will no longer active and it will redirect to 404.php page.</p>';
			$lcadminhelphtml .= '<p> 	-	You will get alternative login page url in status tab and also can see Choose Template tab </p>';

			$lcadminhelphtml .= '<p>4.	Settings > Tab Choose Template</p>';

			$lcadminhelphtml .= '<p> 	-	By default first templete is selected but you may choose other template for login page and save it. </p>';

			$lcadminhelphtml .= '<p>* By disable the option from status tab you may able to access wp-login.php and wp-admin again as previous.</p>';

			$lcadminhelphtml .= '</div></div></div></div>';

			echo $lcadminhelphtml;
		}
	}
}