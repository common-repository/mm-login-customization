<?php
ob_start();
/*
Template Name: Second Login Template
*/

get_header();
?>
<?php
if(is_user_logged_in())
{
  wp_safe_redirect(site_url());
}
else{
?>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Sign In </h2>
    <?php
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    ?>
    <div><?php sanitize_text_field(get_bloginfo( 'name' ) ) ?><span><?php sanitize_text_field(get_bloginfo( 'description' )) ?></span></div>

    <!-- Icon -->
    <div class="fadeIn first lclogo">
      <?php
      $user = wp_get_current_user();
      ?>
      <img src="<?php echo $image[0]; ?>" id="icon" alt="Site Logo" />
    </div>

    <div class="login">
				<?php echo wp_login_form(); ?>

				<div class="notice">
				<?php
				if(isset($_REQUEST['login']) and ($_REQUEST['login'] == 'fail'))
				{
					echo sanitize_text_field('Username password missmatched. Try again');
				}
				?>
		</div>
	</div>

    

  </div>
</div>
<?php
}
get_footer();
