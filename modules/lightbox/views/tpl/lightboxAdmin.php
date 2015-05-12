<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper" style="max-width: 1100px;">
            <h3 style="float: left; width: 40%;"><?php _e('Lightbox by Supsystic settings', LBS_LANG_CODE)?></h3>
			<ul class="supsystic-bar-controls">
				<li title="<?php _e('Save', LBS_LANG_CODE)?>">
					<button id="lbsSaveSettings" class="button button-primary" form="lbsSettingsForm">
                        <?php _e('Save', LBS_LANG_CODE)?>
                        <i class="fa fa-save"></i>
                    </button>
				</li>
                <li title="<?php _e('Preview', LBS_LANG_CODE)?>">
                    <button id="lbsPreview" class="button button-primary" disabled>
                        <?php _e('Preview', LBS_LANG_CODE)?>
                        <i class="fa fa-eye"></i>
                    </button>
                </li>
                <li title="<?php _e('State', LBS_LANG_CODE)?>">
                    <button id="lbsToggle" class="button button-primary" disabled>
                        <?php _e('Turn off', LBS_LANG_CODE)?>
                        <i class="fa fa-toggle-off"></i>
                    </button>
                </li>
			</ul>
			<div style="clear: both;"></div>
			<hr />

            <form id="lbsSettingsForm">
            <div class="hal-page-right">
                <h3><?php _e('General settings', LBS_LANG_CODE)?></h3>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Apply to all images', LBS_LANG_CODE)?></div>
                    <input type="radio" class="setting-element" name="general[all]" <?php if(isset($this->savedSettings->all) && $this->savedSettings->all) echo 'checked'; ?> data-type="general">
                </div>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Show on specific pages', LBS_LANG_CODE)?></div>
                    <input type="radio" class="setting-element" name="general[page]" <?php if(isset($this->savedSettings->page) && $this->savedSettings->page) echo 'checked'; ?> data-type="general">
                </div>

                <button id="open-pages-dialog" class="button button-primary" style="margin-top: 10px;">
                    <i class="fa fa-check"></i>
                    <?php _e('Show posts and pages manager', LBS_LANG_CODE)?>
                </button>

                <h3><?php _e('Size and spaces', LBS_LANG_CODE)?></h3>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Width', LBS_LANG_CODE)?></div>
                    <input type="text" class="setting-element" name="general[maxWidth]" value="<?php if(isset($this->savedSettings->maxWidth) && $this->savedSettings->maxWidth) echo $this->savedSettings->maxWidth; ?>">
                </div>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Height', LBS_LANG_CODE)?></div>
                    <input type="text" class="setting-element" name="general[maxHeight]" value="<?php if(isset($this->savedSettings) && $this->savedSettings->maxHeight) echo $this->savedSettings->maxHeight; ?>">
                </div>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Offset from top', LBS_LANG_CODE)?></div>
                    <input type="text" class="setting-element" name="general[margin]" value="<?php if(isset($this->savedSettings->margin) && $this->savedSettings->margin) echo $this->savedSettings->margin; ?>">
                   <div class="settings-title"><?php _e('Inside offset', LBS_LANG_CODE)?></div>
                    <input type="text" class="setting-element" name="general[padding]" value="<?php if(isset($this->savedSettings->padding) && $this->savedSettings->padding) echo $this->savedSettings->padding; ?>">
                </div>

                <h3 style="clear: left;"><?php _e('Mode', LBS_LANG_CODE)?></h3>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Single image mode', LBS_LANG_CODE)?></div>
                    <input type="radio" class="setting-element" name="general[single]" <?php if(isset($this->savedSettings->single) && $this->savedSettings->single) echo 'checked'; ?> data-type="mode">
                </div>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Gallery mode', LBS_LANG_CODE)?></div>
                    <input type="radio" class="setting-element" name="general[gallery]" <?php if(isset($this->savedSettings->gallery) && $this->savedSettings->gallery) echo 'checked'; ?> data-type="mode">
                </div>

                <h3><?php _e('Slideshow', LBS_LANG_CODE)?></h3>
                <div class="settings-line">
                    <div class="settings-title"><?php _e('Enable', LBS_LANG_CODE)?></div>
                    <input type="checkbox" class="setting-element" name="general[autoPlay]" <?php if(isset($this->savedSettings->autoPlay) && $this->savedSettings->autoPlay) echo 'checked' ?> >
                </div>

                <div class="settings-line">
                    <div class="settings-title"><?php _e('Speed', LBS_LANG_CODE)?></div>
                    <input type="text" class="setting-element" name="general[playSpeed]" value="<?php if(isset($this->savedSettings->playSpeed) && $this->savedSettings->playSpeed) echo $this->savedSettings->playSpeed; ?>">
                </div>
            </div>

                <div class="hal-page-left">

                    <h3><?php _e('Additional effects', LBS_LANG_CODE)?></h3>
                    <div class="settings-line">
                        <div class="settings-title"><?php _e('Show close Button', LBS_LANG_CODE)?></div>
                        <input type="checkbox" class="setting-element" name="general[closeBtn]" <?php if(isset($this->savedSettings->closeBtn) && $this->savedSettings->closeBtn) echo 'checked' ?> >
                    </div>

                    <div class="settings-line">
                        <div class="settings-title"><?php _e('Translate on click', LBS_LANG_CODE)?></div>
                        <input type="checkbox" class="setting-element" name="general[nextClick]" <?php if(isset($this->savedSettings->nextClick) && $this->savedSettings->nextClick) echo 'checked' ?> >
                    </div>

                    <div class="settings-line">
                        <div class="settings-title"><?php _e('Wheel navigation', LBS_LANG_CODE)?></div>
                        <input type="checkbox" class="setting-element" name="general[mouseWheel]" <?php if(isset($this->savedSettings->mouseWheel) && $this->savedSettings->mouseWheel) echo 'checked' ?> >
                    </div>

                    <div class="settings-line" style="height: 30px;">
                        <div class="settings-title"><?php _e('Open effect', LBS_LANG_CODE)?></div>
                        <select class="setting-element" name="general[openEffect]">
                            <option value="fade" <?php if($this->savedSettings->openEffect == 'fade') echo 'selected' ?> ><?php _e('Fade', LBS_LANG_CODE)?></option>
                            <option value="elastic" <?php if($this->savedSettings->openEffect == 'elastic') echo 'selected' ?> ><?php _e('Elastic', LBS_LANG_CODE)?></option>
                            <option value="none" <?php if($this->savedSettings->openEffect == 'none') echo 'selected' ?> ><?php _e('None', LBS_LANG_CODE)?></option>
                        </select>
                    </div>

                    <div class="settings-line" style="height: 30px;">
                        <div class="settings-title"><?php _e('Close effect', LBS_LANG_CODE)?></div>
                        <select class="setting-element" name="general[closeEffect]">
                            <option value="fade" <?php if($this->savedSettings->closeEffect == 'fade') echo 'selected' ?> ><?php _e('Fade', LBS_LANG_CODE)?></option>
                            <option value="elastic" <?php if($this->savedSettings->closeEffect == 'elastic') echo 'selected' ?> ><?php _e('Elastic', LBS_LANG_CODE)?></option>
                            <option value="none" <?php if($this->savedSettings->closeEffect == 'none') echo 'selected' ?> ><?php _e('None', LBS_LANG_CODE)?></option>
                        </select>
                    </div>

                    <h3><?php _e('View helpers', LBS_LANG_CODE)?></h3>
                    <div class="settings-line">
                        <div class="settings-title"><?php _e('Thumbnails navigation', LBS_LANG_CODE)?></div>
                        <input type="checkbox" class="setting-element" name="general[helpers][thumbs]" <?php if(isset($this->savedSettings->helpers->thumbs) && $this->savedSettings->helpers->thumbs) echo 'checked' ?> >
                    </div>
                    <div class="settings-line">
                        <div class="settings-title"><?php _e('Buttons', LBS_LANG_CODE)?></div>
                        <input type="checkbox" class="setting-element" name="general[helpers][buttons]" <?php if(isset($this->savedSettings->helpers->buttons) && $this->savedSettings->helpers->buttons) echo 'checked' ?> >
                    </div>
                    <div class="settings-line" style="height: 30px;">
                        <div class="settings-title"><?php _e('Title', LBS_LANG_CODE)?></div>
                        <select class="setting-element" name="general[helpers][title][type]">
                            <option value="float" <?php if($this->savedSettings->helpers->title->type == 'float') echo 'selected' ?> ><?php _e('Float', LBS_LANG_CODE)?></option>
                            <option value="inside" <?php if($this->savedSettings->helpers->title->type == 'inside') echo 'selected' ?> ><?php _e('Inside', LBS_LANG_CODE)?></option>
                            <option value="outside" <?php if($this->savedSettings->helpers->title->type == 'outside') echo 'selected' ?> ><?php _e('Outside', LBS_LANG_CODE)?></option>
                            <option value="null" <?php if($this->savedSettings->helpers->title->type == 'null') echo 'selected' ?> ><?php _e('None', LBS_LANG_CODE)?></option>
                        </select>
                    </div>
                </div>

                <div class="posts-and-pages-dialog" hidden>
                    <h1><?php _e('Selected pages and posts', LBS_LANG_CODE)?></h1>
                    <div class="settings-line" style="margin-top: 20px;">
                        <h3 class="settings-title"><?php _e('Pages', LBS_LANG_CODE)?></h3>
                        <select id="show-pages" class="setting-element add-page-list" style="width: 200px;">
                            <?php foreach(get_pages(array('posts_per_page' => '-1')) as $page) {
                                echo '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
                            } ?>
                        </select>
                        <button id="add-page" class="button button-primary" style="height: 30px;">
                            <i class="fa fa-check"></i>
                            <?php _e('Add', LBS_LANG_CODE)?>
                        </button>
                    </div>
                    <div class="settings-line" style="margin-top: 10px;">
                        <h3 class="settings-title"><?php _e('Posts', LBS_LANG_CODE)?></h3>
                        <select id="show-posts" class="setting-element add-post-list" style="width: 200px;">
                            <?php foreach(get_posts(array('posts_per_page' => '-1')) as $post) {
                                echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
                            } ?>
                        </select>
                        <button id="add-post" class="button button-primary" style="height: 30px;">
                            <i class="fa fa-check"></i>
                            <?php _e('Add', LBS_LANG_CODE)?>
                        </button>
                    </div>

                    <h3 class="settings-title"><?php _e('Added', LBS_LANG_CODE)?></h3>
                    <table id="jq-post-pages-table"></table>
                </div>

                <?php echo htmlLbs::hidden('mod', array('value' => 'lightbox'))?>
                <?php echo htmlLbs::hidden('action', array('value' => 'saveAction'))?>
            </form>
		</div>
		<div style="clear: both;"></div>
	</div>
</section>