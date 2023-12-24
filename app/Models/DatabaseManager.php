<?php

declare(strict_types=1);

namespace App\Models;

use Nette\Database\Explorer;
use Nette\SmartObject;

abstract class DatabaseManager {

	use SmartObject;

	protected Explorer $database;

	public function __construct(Explorer $database) {
		$this->database = $database;
	}
}