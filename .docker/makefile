docker-up:
	docker-compose -p todo-nette up -d --build --force-recreate

docker-down:
	docker-compose -p todo-nette down

phpstan:
	docker exec todo-nette vendor/bin/phpstan analyse app

composer-install:
	docker exec todo-nette composer install

composer-update:
	docker exec todo-nette composer update