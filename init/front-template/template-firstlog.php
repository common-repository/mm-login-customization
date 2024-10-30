<?php
ob_start();
/*
Template Name: First Login Template
 */
wp_head();
?>
<?php
if(is_user_logged_in())
{
	wp_safe_redirect(site_url());
}
else{
?>
<main id="site-content" role="main">
<div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<a href="#" class="head-sign"><div>Sign In</div></a>
			<br />
			<a href="<?php echo site_url(); ?>"><div class="head-title"><?php echo sanitize_text_field(get_bloginfo( 'name' )) ?><br/><span class="tag_lc"><?php echo sanitize_text_field(get_bloginfo( 'description' )) ?></span></div></a>
		</div>
		<br>
		<div class="login">
				<?php echo wp_login_form(); ?>
		</div>

		<div class="notice">
			<?php
			if(isset($_REQUEST['login']) and ($_REQUEST['login'] == 'fail'))
			{
				echo sanitize_text_field('Username password missmatched. Try again');
			}
			?>
		</div>
</main>
<?php
}
wp_footer();

