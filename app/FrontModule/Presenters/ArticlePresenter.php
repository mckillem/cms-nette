<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Models\ArticleManager;
use App\Models\CommentManager;
use App\Components\Comments;

class ArticlePresenter extends BaseFrontPresenter {

	/** @var int */
	private int $article_id;

	/** @var ArticleManager */
	private ArticleManager $articleManager;

	/** @var CommentManager */
	private CommentManager $commentManager;

	/**
	 * @param ArticleManager $articleManager
	 * @param CommentManager $commentManager
	 */
	public function __construct(ArticleManager $articleManager, CommentManager $commentManager) {
		parent::__construct();
		$this->articleManager = $articleManager;
		$this->commentManager = $commentManager;
	}

	public function actionDetail(int $id): void {
		$this->article_id = $id;
	}

	public function renderDefault(string $url): void {
		$parameters = $this->getParameters();
//		todo: je třeba kontrolovat kategorii, protože její zadání není povinné.
// Dává to ale smysl? článek má být aspoň v jedné kategorii
		if ($url && ($category = $this->categoryManager->getCategory($url))) {
			$parameters['category_id'] = $category->id;
		} elseif ($url) {
			$this->flashMessage('Zvolená kategorie neexistuje.');
			$this->redirect(':Front:Homepage:');
		}
		$this->template->categoryName = isset($category) ? $category->name : 'Články';
		$this->template->articles = $this->articleManager->getArticles($parameters);
	}

	public function renderDetail(int $id): void {

		$this->template->article = $this->articleManager->getArticleFromId($id);
		if (!$this->template->article) {
			$this->error();
		}

//todo: špatně, proč?
//		try {
//			$this->template->article = $this->articleManager->getArticleFromId($id);
//		} catch (\Exception $e) {
//			$this->error('Článek nebyl nalezen');
//		}
	}

	public function createComponentComments(): Comments {
		return new Comments($this->commentManager, $this->article_id);
	}
}