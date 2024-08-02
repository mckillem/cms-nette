<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;


class Bootstrap
{
	public static function boot(): Configurator
	{
		$appDir = dirname(__DIR__);
		$configurator = new Configurator;
		//$configurator->setDebugMode('secret@23.75.345.200'); // enable for your remote IP
//		todo: k čemu je ta podmínka a k čemu její obsah?
		if (getenv('NETTE_DEBUG') == 1) {
//			todo: zapne vývojářský režim na tvrdo, což na produkci nechci
			$configurator->setDebugMode(TRUE);
		}
		$configurator->enableTracy($appDir . '/log');
		$configurator->setTempDirectory($appDir . '/temp');
		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();
		$configurator->addConfig($appDir . '/config/common.neon');
		$configurator->addConfig($appDir . '/config/services.neon');
		$configurator->addConfig($appDir . '/config/local.neon');

		return $configurator;
	}
}
