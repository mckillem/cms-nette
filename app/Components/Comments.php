<?php

declare(strict_types=1);

namespace App\Components;

use App\Models\CommentManager;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class Comments extends Control {
	private CommentManager $commentManager;
	private int $article_id;
	private array|null $comments = null;

	public function __construct(CommentManager $commentManager, int $article_id)
	{
		$this->commentManager = $commentManager;
		$this->article_id = $article_id;
	}

	public function getComments(): array
	{
		if ($this->comments === null) {
			$this->comments = $this->commentManager->getComments($this->article_id);
		}

		return $this->comments;
	}

	public function handleDelete(int $id): void
	{
		$this->commentManager->deleteComment($id);
		$this->flashMessage('Komentář byl odstraněn.', 'success');
		$this->getPresenter()->postGet('this');
		$this->getPresenter()->sendPayload();
	}

	public function render(): void
	{
		$this->template->comments = $this->getComments();
//		$this->template->setFile(__DIR__ . '/templates/comments.latte');
//		$this->template->render();
		$this->template->render(__DIR__ . '/templates/comments.latte');
	}

	public function doAddComment(Form $form, array $values): void
	{
		$comment = $this->commentManager->addComment($this->article_id, $values);
		$this->flashMessage('Komentář byl přidán.', 'success');
		$this->getPresenter()->postGet('this');
		$this->redrawControl('list');
		$this->comments = [$comment];
	}

	public function createComponentCommentForm(): Form
	{
		$form = new Form();
		$form->addText('author_name', 'Vaše jméno:')
			->setRequired(true);
		$form->addEmail('author_email', 'Váš email:')
			->setRequired(true);
		$form->addTextArea('content', 'Komentář:')
			->setRequired(true);
		$form->addSubmit('add', 'Přidat');
		$form->onSuccess[] = [$this, 'doAddComment'];

		return $form;
	}
}