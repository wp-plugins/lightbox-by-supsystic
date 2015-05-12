<div class="lbsAdminFooterShell">
	<div class="lbsAdminFooterCell">
		<?php echo LBS_WP_PLUGIN_NAME?>
		<?php _e('Version', LBS_LANG_CODE)?>:
		<a target="_blank" href="http://wordpress.org/plugins/lightbox-by-supsystic/changelog/"><?php echo LBS_VERSION?></a>
	</div>
	<div class="lbsAdminFooterCell">|</div>
	<?php  if(!frameLbs::_()->getModule(implode('', array('l','ic','e','ns','e')))) {?>
	<div class="lbsAdminFooterCell">
		<?php _e('Go', LBS_LANG_CODE)?>&nbsp;<a target="_blank" href="<?php echo $this->getModule()->preparePromoLink('http://supsystic.com/plugins/lightbox-plugin/');?>"><?php _e('PRO', LBS_LANG_CODE)?></a>
	</div>
	<div class="lbsAdminFooterCell">|</div>
	<?php } ?>
	<div class="lbsAdminFooterCell">
		<a target="_blank" href="http://wordpress.org/support/plugin/lightbox-by-supsystic"><?php _e('Support', LBS_LANG_CODE)?></a>
	</div>
	<div class="lbsAdminFooterCell">|</div>
	<div class="lbsAdminFooterCell">
		Add your <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/lightbox-by-supsystic?filter=5#postform">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on wordpsess.org.
	</div>
</div>