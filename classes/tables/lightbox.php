<?php
class tableLightboxLbs extends tableLbs {
    public function __construct() {
        $this->_table = '@__lightbox';
        $this->_id = 'id';
        $this->_alias = 'sup_lightbox';
        $this->_addField('id', 'text', 'int')
				->_addField('settings', 'text', 'text')
                ->_addField('pages', 'text', 'text');
    }
}