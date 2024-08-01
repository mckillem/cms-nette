<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

class CmsPresenter extends BaseFrontPresenter {

	public function renderDefault(string $url) {

		$this->template->page = $this->cmsManager->getCmsPage($url);
		if (!$this->template->page) {
			$this->error();
		}
		//todo: špatně, proč?
//		try {
//			$this->template->page = $this->cmsManager->getCmsPage($url);
//		} catch (\Exception $e) {
//			$this->error('Stránka nebyla nalezena.');
//		}
	}
}
