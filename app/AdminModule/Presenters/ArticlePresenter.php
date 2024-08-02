<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Models\ArticleManager;
use App\Models\CategoryManager;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Tomaj\Form\Renderer\BootstrapVerticalRenderer;

class ArticlePresenter extends BaseAdminPresenter {
	private ArticleManager $articleManager;
	private CategoryManager $categoryManager;

	public function __construct(ArticleManager $articleManager, CategoryManager $categoryManager) {
		parent::__construct();
		$this->articleManager = $articleManager;
		$this->categoryManager = $categoryManager;
	}

	public function renderList(): void {
		$this->template->articles = $this->articleManager->getAllArticles();
	}

	public function actionRemove(string $url = null): void {
		$this->articleManager->removeArticle($url);
		$this->flashMessage('Článek byl úspěšně odstraněn.');
		$this->redirect('Article:list');
	}

	public function actionEditor(string $url = null): void {
		if ($url) {
			if (!($article = $this->articleManager->getArticle($url))) {
				$this->flashMessage('Článek nebyl nalezen.');
			} else {
				$this['editorForm']->setDefaults($article);
			}
		}
	}

	protected function createComponentEditorForm(): Form {
		$form = new Form;
		$form->setRenderer(new BootstrapVerticalRenderer);
		$form->addHidden('id');
		$form->addText('title', 'Titulek')
			->setRequired();
		$form->addText('url', 'URL')
			->setRequired();
		$form->addUpload('picture', 'Obrázek:')
			->setRequired(false)
			->addCondition(Form::FILLED);
//			->addRule(Form::IMAGE);
		$form->addText('short_description', 'Popisek')
			->setRequired();
		$form->addTextArea('description', 'Obsah');
		$categories = $this->categoryManager->getAllCategory();
		$form->addSelect('categories', 'Kategorie:', $categories)
			->setRequired()
//			todo: zajistit, aby při editaci byla kategorie správně vyplněna (ostatní pole to vyplní),
// páč když edituju, tak nemusím vědět v jaké kategorii článek je
			->setPrompt('Zvolte kategorii');
		$form->addSubmit('save', 'Uložit článek');
		$form->onSuccess[] = function (Form $form, Array $values) {
			try {
				$this->articleManager->saveArticle($values);
				$this->flashMessage('Článek byl úspěšně uložen.');
				$this->redirect('Article:list');
			} catch (UniqueConstraintViolationException $e) {
				$this->flashMessage('Článek s touto URL adresou již existuje.');
			}
		};

		return $form;
	}
}