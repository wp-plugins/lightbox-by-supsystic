<?php
class admin_navControllerLbs extends controllerLbs {
	public function getPermissions() {
		return array(
			LBS_USERLEVELS => array(
				LBS_ADMIN => array()
			),
		);
	}
}