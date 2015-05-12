jQuery(document).ready(function(){
	jQuery('#lbsSettingsSaveBtn').click(function(){
		jQuery('#lbsSettingsForm').submit();
		return false;
	});
	jQuery('#lbsSettingsForm').submit(function(){
		jQuery(this).sendFormLbs({
			btn: jQuery('#lbsSettingsSaveBtn')
		});
		return false;
	});
});