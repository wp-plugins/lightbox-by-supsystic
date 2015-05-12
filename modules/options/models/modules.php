<?php
class modulesModelLbs extends modelLbs {
    public function get($d = array()) {
        if(isset($d['id']) && $d['id'] && is_numeric($d['id'])) {
            $fields = frameLbs::_()->getTable('modules')->fillFromDB($d['id'])->getFields();
            $fields['types'] = array();
            $types = frameLbs::_()->getTable('modules_type')->fillFromDB();
            foreach($types as $t) {
                $fields['types'][$t['id']->value] = $t['label']->value;
            }
            return $fields;
        } elseif(!empty($d)) {
            $data = frameLbs::_()->getTable('modules')->get('*', $d);
            return $data;
        } else {
            return frameLbs::_()->getTable('modules')
                ->innerJoin(frameLbs::_()->getTable('modules_type'), 'type_id')
                ->getAll(frameLbs::_()->getTable('modules')->alias().'.*, '. frameLbs::_()->getTable('modules_type')->alias(). '.label as type');
        }
    }
    public function put($d = array()) {
        $res = new responseLbs();
        $id = $this->_getIDFromReq($d);
        $d = prepareParamsLbs($d);
        if(is_numeric($id) && $id) {
            if(isset($d['active']))
                $d['active'] = ((is_string($d['active']) && $d['active'] == 'true') || $d['active'] == 1) ? 1 : 0;           //mmm.... govnokod?....)))
           /* else
                 $d['active'] = 0;*/
            
            if(frameLbs::_()->getTable('modules')->update($d, array('id' => $id))) {
                $res->messages[] = __('Module Updated', LBS_LANG_CODE);
                $mod = frameLbs::_()->getTable('modules')->getById($id);
                $newType = frameLbs::_()->getTable('modules_type')->getById($mod['type_id'], 'label');
                $newType = $newType['label'];
                $res->data = array(
                    'id' => $id, 
                    'label' => $mod['label'], 
                    'code' => $mod['code'], 
                    'type' => $newType,
                    'active' => $mod['active'], 
                );
            } else {
                if($tableErrors = frameLbs::_()->getTable('modules')->getErrors()) {
                    $res->errors = array_merge($res->errors, $tableErrors);
                } else
                    $res->errors[] = __('Module Update Failed', LBS_LANG_CODE);
            }
        } else {
            $res->errors[] = __('Error module ID', LBS_LANG_CODE);
        }
        return $res;
    }
    protected function _getIDFromReq($d = array()) {
        $id = 0;
        if(isset($d['id']))
            $id = $d['id'];
        elseif(isset($d['code'])) {
            $fromDB = $this->get(array('code' => $d['code']));
            if(isset($fromDB[0]) && $fromDB[0]['id'])
                $id = $fromDB[0]['id'];
        }
        return $id;
    }
}
