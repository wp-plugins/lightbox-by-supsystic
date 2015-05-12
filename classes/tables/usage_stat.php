<?php
class tableUsage_statLbs extends tableLbs {
    public function __construct() {
        $this->_table = '@__usage_stat';
        $this->_id = 'id';     
        $this->_alias = 'sup_usage_stat';
        $this->_addField('id', 'hidden', 'int', 0, __('id', LBS_LANG_CODE))
			->_addField('code', 'hidden', 'text', 0, __('code', LBS_LANG_CODE))
			->_addField('visits', 'hidden', 'int', 0, __('visits', LBS_LANG_CODE))
			->_addField('spent_time', 'hidden', 'int', 0, __('spent_time', LBS_LANG_CODE))
			->_addField('modify_timestamp', 'hidden', 'int', 0, __('modify_timestamp', LBS_LANG_CODE));
    }
}