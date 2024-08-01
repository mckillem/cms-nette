<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use Nittro\Bridges\NittroUI\Presenter;
use App\Models\CategoryManager;
use App\Models\CmsManager;

abstract class BaseFrontPresenter extends Presenter {
	protected CategoryManager $categoryManager;
	protected CmsManager $cmsManager;

	public function injectManagerDependencies(
		CategoryManager $categoryManager,
		CmsManager $cmsManager) {
		$this->categoryManager = $categoryManager;
		$this->cmsManager = $cmsManager;
	}

	protected function startup() {
		parent::startup();
		$this->setDefaultSnippets(['header', 'content']);
	}

	protected function beforeRender() {
		parent::beforeRender();
		$this->template->domain = $this->getHttpRequest()->getUrl()->getHost();
		$this->template->categories = $this->categoryManager->getCategories();
		$this->template->menuItems = $this->cmsManager->getMenuItems();
	}
}