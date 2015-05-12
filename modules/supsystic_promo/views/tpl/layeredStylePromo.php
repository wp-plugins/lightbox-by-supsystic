<div class="lbsPopupOptRow">
	<label>
		<a target="_blank" href="<?php echo $this->promoLink?>" class="sup-promolink-input">
			<?php echo htmlLbs::checkbox('layered_style_promo', array(
				'checked' => 1,
				//'attrs' => 'disabled="disabled"',
			))?>
			<?php _e('Enable Layered PopUp Style', LBS_LANG_CODE)?>
		</a>
		<a target="_blank" class="button" style="margin-top: -8px;" href="<?php echo $this->promoLink?>"><?php _e('Available in PRO', LBS_LANG_CODE)?></a>
	</label>
	<div class="description"><?php _e('By default all PopUps - have modal style: it appear on user screen over the whole site. Layered style allow you to show your PopUp - on selected position: top, bottom, etc. and not over your site - but right near your content.', LBS_LANG_CODE)?></div>
</div>
<span>
	<div class="lbsPopupOptRow">
		<span class="lbsOptLabel"><?php _e('Select position for your PopUp', LBS_LANG_CODE)?></span>
		<br style="clear: both;" />
		<div id="lbsLayeredSelectPosShell">
			<div class="lbsLayeredPosCell" style="width: 30%;" data-pos="top_left"><span class="lbsLayeredPosCellContent"><?php _e('Top Left', LBS_LANG_CODE)?></span></div>
			<div class="lbsLayeredPosCell" style="width: 40%;" data-pos="top"><span class="lbsLayeredPosCellContent"><?php _e('Top', LBS_LANG_CODE)?></span></div>
			<div class="lbsLayeredPosCell" style="width: 30%;" data-pos="top_right"><span class="lbsLayeredPosCellContent"><?php _e('Top Right', LBS_LANG_CODE)?></span></div>
			<br style="clear: both;"/>
			<div class="lbsLayeredPosCell" style="width: 30%;" data-pos="center_left"><span class="lbsLayeredPosCellContent"><?php _e('Center Left', LBS_LANG_CODE)?></span></div>
			<div class="lbsLayeredPosCell" style="width: 40%;" data-pos="center"><span class="lbsLayeredPosCellContent"><?php _e('Center', LBS_LANG_CODE)?></span></div>
			<div class="lbsLayeredPosCell" style="width: 30%;" data-pos="center_right"><span class="lbsLayeredPosCellContent"><?php _e('Center Right', LBS_LANG_CODE)?></span></div>
			<br style="clear: both;"/>
			<div class="lbsLayeredPosCell" style="width: 30%;" data-pos="bottom_left"><span class="lbsLayeredPosCellContent"><?php _e('Bottom Left', LBS_LANG_CODE)?></span></div>
			<div class="lbsLayeredPosCell" style="width: 40%;" data-pos="bottom"><span class="lbsLayeredPosCellContent"><?php _e('Bottom', LBS_LANG_CODE)?></span></div>
			<div class="lbsLayeredPosCell" style="width: 30%;" data-pos="bottom_right"><span class="lbsLayeredPosCellContent"><?php _e('Bottom Right', LBS_LANG_CODE)?></span></div>
			<br style="clear: both;"/>
		</div>
		<?php echo htmlLbs::hidden('params[tpl][layered_pos]')?>
	</div>
</span>
<style type="text/css">
	#lbsLayeredSelectPosShell {
		max-width: 560px;
		height: 380px;
	}
	.lbsLayeredPosCell {
		float: left;
		cursor: pointer;
		height: 33.33%;
		text-align: center;
		vertical-align: middle;
		line-height: 120px;
	}
	.lbsLayeredPosCellContent {
		border: 2px solid #000;
		margin: 5px;
		display: block;
		font-weight: bold;
	}
	.lbsLayeredPosCellContent:hover, .lbsLayeredPosCell.active .lbsLayeredPosCellContent {
		background-color: #4ae8ea;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var proExplainContent = jQuery('#lbsLayeredProExplainWnd').dialog({
			modal:    true
		,	autoOpen: false
		,	width: 460
		,	height: 180
		});
		jQuery('.lbsLayeredPosCell').click(function(){
			proExplainContent.dialog('open');
		});
	});
</script>
<!--PRO explanation Wnd-->
<div id="lbsLayeredProExplainWnd" style="display: none;" title="<?php _e('Improve Free version', LBS_LANG_CODE)?>">
	<p>
		<?php printf(__('This functionality and more - is available in PRO version. <a class="button button-primary" target="_blank" href="%s">Get it</a> today for 29$', LBS_LANG_CODE), $this->promoLink)?>
	</p>
</div>