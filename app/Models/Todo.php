<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Explorer;

class Todo
{
	public Explorer $db;

	public function __construct(Explorer $db)
	{
		$this->db = $db;
	}

	public function getAllTodos() {
//		return $this->db->table('todo')->fetchAll();
		return  $this->db->table('article')
			->order('date_add DESC')
			->limit(5);
	}

	public function saveTodo(\stdClass $data) {
		$this->db->table('todo')->insert([
			'title' => $data->title,
		]);
	}

	public function deleteTodo(int $id) {
		$this->db->table('todo')->where('id', $id)->delete();
	}
}