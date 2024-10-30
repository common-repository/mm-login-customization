/* Js for admin */

jQuery(document).ready(function(){
	

	jQuery('#lc-tab-status').hide();
  	jQuery('#lc-tab-settings').hide();
  	jQuery('#lc-tab-template').hide();


  	jQuery('#lc-tab-status').show();

  	jQuery('#lc_status_id_a').removeClass('lc_active');
  	jQuery('#lc_settings_id_a').removeClass('lc_active');
  	jQuery('#lc_template_id_a').removeClass('lc_active');

  	jQuery('#lc_status_id_a').addClass('lc_active');

});

jQuery("#lc_status_id a").click(function(){
  jQuery('#lc-tab-status').hide();
  jQuery('#lc-tab-settings').hide();
  jQuery('#lc-tab-template').hide();

 

  jQuery('#lc-tab-status').show();

  jQuery('#lc_status_id_a').removeClass('lc_active');
  jQuery('#lc_settings_id_a').removeClass('lc_active');
  jQuery('#lc_template_id_a').removeClass('lc_active');

  jQuery('#lc_status_id_a').addClass('lc_active');
});

jQuery("#lc_settings_id").click(function(){
  jQuery('#lc-tab-status').hide();
  jQuery('#lc-tab-settings').hide();
  jQuery('#lc-tab-template').hide();

  jQuery('#lc-tab-settings').show();


  jQuery('#lc_status_id_a').removeClass('lc_active');
  jQuery('#lc_settings_id_a').removeClass('lc_active');
  jQuery('#lc_template_id_a').removeClass('lc_active');

  jQuery('#lc_settings_id_a').addClass('lc_active');
});

jQuery("#lc_template_id a").click(function(){
  jQuery('#lc-tab-status').hide();
  jQuery('#lc-tab-settings').hide();
  jQuery('#lc-tab-template').hide();

  jQuery('#lc-tab-template').show();
  
  jQuery('#lc_status_id_a').removeClass('lc_active');
  jQuery('#lc_settings_id_a').removeClass('lc_active');
  jQuery('#lc_template_id_a').removeClass('lc_active');

  jQuery('#lc_template_id_a').addClass('lc_active');
});

jQuery("input[name='lcstatus']").click(function(){
    
	    if(jQuery('input:radio[name=lcstatus]:checked').val() == "enable"){
	    	jQuery.ajax({
			type: "POST",
			url: lc_admin_localize_ajax_url.admin_url,
			data: {
				action: 'get_lc_status',
			},
			success:function( data )
			{
				jQuery('.lc-url').show();
				jQuery('.lc-det-url').html('After enable the setting you will get the login url here');
				jQuery('.lc-url').html(data);

				jQuery('#lccopy').html('');

			},
			error:function()
			{
				console.log('My mistake');
			}

		});

    }
    else
    {
    	jQuery('.lc-det-url').html('');
    	jQuery('.lc-det-url').html('<div>After enable the setting you will get the login url here </div><div class="view_lc_disable"><a href="javascript:void(0);" onclick="save_lc_disable();" class="lccopy_button page-title-action">Disable Now</a> <a href="javascript:void(0);" onclick="referesh_lc_url();" class="lccopy_button page-title-action">Referesh</a></div>');
    	jQuery('.lc-url').html('');
    	jQuery('.lc-url').hide();
    	jQuery('#lccopy').html('');
    }
});

jQuery("input[name='lctemplate']").click(function(){
    var temp = jQuery('input:radio[name=lctemplate]:checked').val()

    jQuery('#template_lc_id').val(temp);
	   
});

function save_lc_disable()
{
	jQuery.ajax({
			type: "POST",
			url: lc_admin_localize_ajax_url.admin_url,
			data: {
				action: 'get_lc_disable',
			},
			success:function( data )
			{
				jQuery('.lc-status-msg').html('<span style="color:green;"> Login Url disable successfully </span>');
				setTimeout(function(){
		            jQuery('.lc-status-msg').html('');
		        }, 5000);

				jQuery('.lc-det-url').html('');
				jQuery('.lc-det-url').html('After enable the setting you will get the login url here'); 
				jQuery('.lc-url').html(data);

				jQuery('#lc_settings_id').hide();
				jQuery('#lc_template_id').hide();
			},
			error:function()
			{
				console.log('My mistake');
			}

		});
}

function save_lc_url()
{
	var lcurl = jQuery('#hidden_log_url_id').val();
	jQuery.ajax({
			type: "POST",
			url: lc_admin_localize_ajax_url.admin_url,
			data: {
				action: 'get_lc_url_save',
				lcurl: lcurl,
				lcstatus: jQuery('input:radio[name=lcstatus]:checked').val(),
			},
			success:function( data )
			{
				jQuery('.lc-status-msg').html('<span style="color:green;"> Login Url saved </span>');
				setTimeout(function(){
		            jQuery('.lc-status-msg').html('');
		        }, 5000);

				jQuery('.lc-det-url').html('Here is your login url: ');
				jQuery('.lc-url').html(data);

				jQuery('#lc_settings_id').show();
				jQuery('#lc_template_id').show();

				jQuery('#lccopy').html('<p><button class="lccopy_button" onclick="return lc_copy_url(\'#now_lc_url\');">Copy URL</button><p>');
			},
			error:function()
			{
				console.log('My mistake');
			}

		});

}

function save_lc_template()
{
	var temp_no = jQuery('#template_lc_id').val();
	var temp = '';


	if(temp_no == 1)
	{
		temp = 'template-firstlog.php';
	}
	else
	{
		if(temp_no == 2)
		{
			temp = 'template-secondlog.php';
		}
	}


	jQuery.ajax({
			type: "POST",
			url: lc_admin_localize_ajax_url.admin_url,
			data: {
				action: 'get_lc_template_save',
				templatevar: temp,
			},
			success:function( data )
			{
				jQuery('#lc-template-msg').html('<span style="color:green;"> Template saved </span>');
				setTimeout(function(){
		            jQuery('#lc-template-msg').html('');
		        }, 5000);

			},
			error:function()
			{
				console.log('My mistake');
			}

	});
}


function referesh_lc_url()
{
	location.reload();

	jQuery('#lc-tab-status').hide();
  	jQuery('#lc-tab-settings').hide();
  	jQuery('#lc-tab-template').hide();

  	jQuery('#lc-tab-status').show();
}

function lc_copy_url(element)
{
	 var $temp = jQuery("<input>");
	 jQuery("body").append($temp);
	 $temp.val(jQuery(element).html()).select();
	 document.execCommand("copy");
	 $temp.remove();
}