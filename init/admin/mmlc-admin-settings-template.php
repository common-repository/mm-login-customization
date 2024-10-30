<?php
if(!class_exists('lcAdminSettingsTemplate')){
	class lcAdminSettingsTemplate
	{
		function __construct(){
			$lcadminenqnow = new loginCustomInit();
			$lcadminenqnow->lc_admin_enque_scripts();
		}

		public function lcTemplateActive()
		{
			$templateSelect = '';
			$templateSelect = sanitize_text_field($_POST['templatevar']);

			$lckey = '';
			$lckey = sanitize_option('lc_url_key', get_option('lc_url_key'));

			global $wpdb;
			$posttbl = $wpdb->prefix.'posts';
			$lccurrent = $wpdb->get_row( "SELECT * FROM ".$posttbl." WHERE `post_name`='".$lckey."'" );

			$lccurrentid = intval($lccurrent->ID);

			update_post_meta( $lccurrentid, '_wp_page_template', $templateSelect );
		}
	}
}
?>