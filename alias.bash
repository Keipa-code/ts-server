################################################################################
################################################################################

# PROXIES (to Docker-containers commands)
alias php="docker-compose run --rm php-cli php"
alias node-cli="docker-compose run --rm frontend-node-cli"
alias composer="docker-compose run --rm php-cli composer"
alias app="docker-compose run --rm php-cli php bin/app.php --ansi"
alias linter="docker-compose run --rm php-cli composer lint"
alias phpcs="docker-compose run --rm php-cli composer phpcs"
alias lint="linter && phpcs"

# Symfony
alias console="docker-compose run --rm php-fpm php ./bin/console"

phpunit() {
  EXECUTE="./vendor/bin/phpunit"
  if [ -f "./bin/phpunit" ]; then
      EXECUTE="./bin/phpunit"
  fi
  docker-compose run --rm php-cli ${EXECUTE} "$@"
}

# Laravel
alias artisan="docker-compose run --rm php-fpm php artisan"

# Yii2
alias yii="docker-compose run --rm php-fpm php yii"

################################################################################
################################################################################

# MAINTENANCE

alias permissions="chmod -R u=rwX,g=rwX,o=rwX ./"


################################################################################
#Doctrine

alias app-validate="app orm:validate-schema"
alias app-diff="app migrations:diff"
alias app-migrate="app migrations:migrate"

################################################################################
################################################################################

alias build-gateway="docker --log-level=debug build --pull --file=gateway/docker/production/nginx/Dockerfile --tag=${REGISTRY}/ts-gateway:${IMAGE_TAG} gateway/docker/production/nginx"

alias build-frontend="docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/ts-frontend:${IMAGE_TAG} frontend"

alias build-api-nginx="docker --log-level=debug build --pull --file=api/docker/production/nginx/Dockerfile --tag=${REGISTRY}/ts-api:${IMAGE_TAG} api"

alias build-api-php-fpm="docker --log-level=debug build --pull --file=api/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/ts-api-php-fpm:${IMAGE_TAG} api"

alias frontend-clear="docker run --rm -v ${PWD}/frontend:/var/www -w /var/www alpine sh -c 'rm -rf build'"
alias frontend-init="frontend-yarn-install"
alias frontend-yarn-install="docker-compose run --rm frontend-node-cli yarn install"
################################################################################
################################################################################

## DOCKER ENVIRONMENT ALIASES

alias env-up="docker-compose up -d"
alias env-stop="docker-compose stop"
alias env-down="docker-compose down --remove-orphans"
alias env-restart="env-stop && env-up"
alias env-build="docker-compose build"
alias env-pull="docker-compose pull"
alias env-rebuild="env-build && env-restart && permissions"
alias env-logs="docker-compose logs"
alias env-destroy="docker-compose down -v --remove-orphans"

env-init() {
  env-pull
  env-build
  env-restart
  permissions
}