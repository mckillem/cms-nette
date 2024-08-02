<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Models\UserManager;
use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use App\Forms\SignUpFormFactory;

class UserPresenter extends BaseAdminPresenter {
	private UserManager $userManager;

	/** @var SignUpFormFactory */
	private $signUpFormFactory;

	public function __construct(UserManager $userManager, SignUpFormFactory $signUpFormFactory) {
		parent::__construct();
		$this->userManager = $userManager;
		$this->signUpFormFactory = $signUpFormFactory;
	}

	public function renderList(): void {
		$this->template->users = $this->userManager->getUsers();
	}

	public function actionRemove(int $id = null): void {
		$this->userManager->removeUser($id);
		$this->flashMessage('Uživatel byl úspěšně odstraněn.');
		$this->redirect('User:list');
	}

	protected function createComponentSignUpForm(): Form {
		return $this->signUpFormFactory->create(function (): void {
			$this->redirect('User:list');
		});
	}
}