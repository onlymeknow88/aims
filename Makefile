sh:
	docker-compose exec core sh
up:
	docker-compose up --quiet-pull -d

.PHONY: sh
