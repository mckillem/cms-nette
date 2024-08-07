<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class CategoryManager extends DatabaseManager {
	const
		TABLE_NAME = 'category',
		COLUMN_ID = 'id',
		COLUMN_TITLE = 'name',
		COLUMN_URL = 'url';

	public function getArticleCategories(int $id): array {
		return $this->database->table(ArticleManager::TABLE_NAME . '_' . self::TABLE_NAME)
			->select(self::COLUMN_ID)
			->where(ArticleManager::COLUMN_ID, $id)
			->fetchPairs(null, self::COLUMN_ID);
	}

	public function updateArticleCategories(int $id, array $categories): void {
		$this->database->table(ArticleManager::TABLE_NAME . '_' . self::TABLE_NAME)
			->where(ArticleManager::COLUMN_ID, $id)
			->delete();
		$rows = array();
		foreach ($categories as $category) {
			$rows[] = array(
				ArticleManager::COLUMN_ID => $id,
				self::COLUMN_ID => $category,
			);
		}
		$this->database->table(ArticleManager::TABLE_NAME . '_' . self::TABLE_NAME)
			->insert($rows);
	}

	public function getArticleCategory(int $id) {
		if ($row = $this->database
			->table(ArticleManager::TABLE_NAME . '_' . self::TABLE_NAME)
			->where(ArticleManager::COLUMN_ID, $id)
			->fetch()
		)
			return $row->ref(self::TABLE_NAME)->url;
		else
			return '';
	}

	public function getCategories(): Selection {
		return $this->database->table(self::TABLE_NAME)
			->order(self::COLUMN_ID . ' ASC');
	}

	public function getAllCategory(): array {
		return $this->database->table(self::TABLE_NAME)
			->fetchPairs(self::COLUMN_ID, self::COLUMN_TITLE);
	}

	public function getCategory(string $url): ActiveRow|null {
		return $this->database->table(self::TABLE_NAME)
			->where(self::COLUMN_URL, $url)
			->fetch();
	}

	public function removeCategory(string $url): void {
		$this->database->table(self::TABLE_NAME)
			->where(self::COLUMN_URL, $url)
			->delete();
	}

	public function saveCategory(array $category): void {
		if (empty($category[self::COLUMN_ID])) {
			unset($category[self::COLUMN_ID]);
			$this->database->table(self::TABLE_NAME)
				->insert($category);
		} else {
			$this->database->table(self::TABLE_NAME)
				->where(self::COLUMN_ID, $category[self::COLUMN_ID])
				->update($category);
		}
	}
}