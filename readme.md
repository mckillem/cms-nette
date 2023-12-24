CMS Nette
=================

How to run
------------
cd .docker  
make docker-up  
make docker-down  

pokud chcu něco spustit v dockeru,tak třeba: docker exec todo-nette php -v

spuštení phpstan v dockeru:  
docker exec todo-nette vendor/bin/phpstan analyse app

