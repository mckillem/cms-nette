<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Nette;
use Nette\Database\Explorer;

final class DashboardPresenter extends BaseAdminPresenter
{
	private Explorer $database;

	public function __construct(Explorer $database)
	{
		$this->database = $database;
	}

	public function renderDefault(): void
	{
		$this->template->text = "Dashboard";
	}
}