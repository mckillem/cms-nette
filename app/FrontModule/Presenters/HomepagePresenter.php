<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

final class HomepagePresenter extends BaseFrontPresenter {
	/**
	 * @return void
	 */
	public function renderDefault(): void {
		$this->template->article = $this->cmsManager->getHomePage();
	}
}
