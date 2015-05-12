<label class="supsystic-tooltip-right" title="<?php echo esc_html(sprintf(__('Show when user try to exit from your site. <a target="_blank" href="%s">Check example.</a>', LBS_LANG_CODE), 'http://supsystic.com/exit-lightbox/?utm_source=plugin&utm_medium=onexit&utm_campaign=lightbox'))?>">
	<a target="_blank" href="<?php echo $this->promoLink?>" class="sup-promolink-input">
		<?php echo htmlLbs::radiobutton('promo_show_on_opt', array(
			'value' => 'on_exit_promo',
			'checked' => false,
		))?>
		<?php _e('On Exit from Site', LBS_LANG_CODE)?>
	</a>
	<a target="_blank" href="<?php echo $this->promoLink?>"><?php _e('Available in PRO')?></a>
</label>