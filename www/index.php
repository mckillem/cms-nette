<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// inicializace prostředí + získání objektu Configurator
$configurator = App\Bootstrap::boot();
// vytvoření DI kontejneru
$container = $configurator->createContainer();
// DI kontejner vytvoří objekt Nette\Application\Application
$application = $container->getByType(Nette\Application\Application::class);
// spuštění Nette aplikace
$application->run();
