<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Models\Todo;
use Nette;
use Nette\Application\UI\Form;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	private Todo $todo;

	public function __construct(Todo $todo)
	{
		$this->todo = $todo;
	}

	public function renderDefault(): void
	{
//		$this->template->todos = $this->todo->getAllTodos();
		$this->template->articles = $this->todo->getAllTodos();
	}

	protected function createComponentTodoForm(): Form
	{
		$form = new Form;

		$form->addText('title', 'Úkol:')
			->setRequired();

		$form->addSubmit('send', 'Přidat');
		$form->onSuccess[] = $this->todoFormSucceeded(...);

		return $form;
	}

	private function todoFormSucceeded(\stdClass $data): void
	{
		$this->todo->saveTodo($data);

		$this->flashMessage('Úkol uložen', 'success');
		$this->redirect('this');
	}

	public function actionDelete(int $id): void
	{
		$this->todo->deleteTodo($id);

		$this->flashMessage('Úkol byl smazán', 'success');
		$this->redirect('Homepage:default');
	}
}
