<?php
class dateLbs {
	static public function _($time = NULL) {
		if(is_null($time)) {
			$time = time();
		}
		return date(LBS_DATE_FORMAT_HIS, $time);
	}
}