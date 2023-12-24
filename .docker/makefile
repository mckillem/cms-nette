docker-up:
	docker-compose -p cms-nette up -d --build --force-recreate

docker-down:
	docker-compose -p cms-nette down

phpstan:
	docker exec cms-nette vendor/bin/phpstan analyse app

composer-install:
	docker exec cms-nette composer install

composer-update:
	docker exec cms-nette composer update