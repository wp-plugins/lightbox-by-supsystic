<?php
class admin_navViewLbs extends viewLbs {
	public function getBreadcrumbs() {
		$this->assign('breadcrumbsList', dispatcherLbs::applyFilters('mainBreadcrumbs', $this->getModule()->getBreadcrumbsList()));
		return parent::getContent('adminNavBreadcrumbs');
	}
}
