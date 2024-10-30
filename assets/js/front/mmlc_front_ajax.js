/* Js frontend */

jQuery(document).ready(function(){
	jQuery('#user_login').attr( 'placeholder', 'User Name' );
	jQuery('#user_pass').attr( 'placeholder', 'Password' );
	jQuery('#user_login').prop('required',true);
	jQuery('#user_pass').prop('required',true);
});