DOCKER_COMPOSE_PATH=../docker-compose.yml

showWelcomeMessage() {
    cat ./welcome_prompt.txt
}

copyEnvFile() {
    echo "Copying .env file..."
    if [ -f  "../.env" ]; then
        echo ".env file already exists"
    else
        cp ../.env.example ../.env
        echo ".env file copied successfully"
    fi
}

prepareEnvFileForProduction() {
    if [ "$2" = "--prod" ]; then
        echo "Preparing .env file for production..."
        sed -i 's/APP_ENV=local/APP_ENV=production/g' ../.env
        sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' ../.env
        sed -i 's/APP_URL=http:\/\/localhost/APP_URL=https:\/\/anilonay.com/g' ../.env
    fi
}

buildDocker() {
    echo "Building Docker..."

    docker-compose -f "$DOCKER_COMPOSE_PATH" build ${2:+"--no-cache"}
}

startDocker() {
    echo "Starting Docker..."
    docker-compose -f "$DOCKER_COMPOSE_PATH" up -d
}

stopDocker() {
    echo "Stopping Docker..."
    docker-compose -f "$DOCKER_COMPOSE_PATH" down
}

composerInstall() {
    if [ ! -d "../vendor" ] || [ "$2" = "--prod" ]; then
        echo "Installing Composer dependencies..."
        docker-compose -f "$DOCKER_COMPOSE_PATH" exec php composer install ${2:+"--no-dev"}
    fi
}

prepareLaravel() {
    echo "Preparing Laravel..."
    docker-compose -f "$DOCKER_COMPOSE_PATH" exec php chmod -R 777 ./storage
    composerInstall

    if [ "$2" = "--prod" ]; then
        docker-compose -f "$DOCKER_COMPOSE_PATH" exec php sh -c '
        php artisan config:cache &&
        php artisan route:cache &&
        php artisan view:cache &&
        php artisan event:cache &&
        php artisan optimize &&
        php artisan key:generate --show  --no-interaction &&
        php artisan migrate:fresh --seed --force'
        # TODO Check migration + Key generation checks for production.
    else
        docker-compose -f "$DOCKER_COMPOSE_PATH" exec php sh -c '
        php artisan config:clear &&
        php artisan route:clear &&
        php artisan view:clear &&
        php artisan event:clear &&
        php artisan key:generate --show  --no-interaction &&
        php artisan migrate:fresh --seed'
    fi
}

help() {
    echo "Usage: ./deployer.sh [command]"
    echo "Commands:"
    echo "  magic: Build, start, and prepare Laravel (Useful arg: --no-cache || --prod)"
    echo "  up: Start all services"
    echo "  down: Stop all services"
    echo "  help: Show available commands"
}

if [ "$1" = "magic" ]; then
    showWelcomeMessage
    copyEnvFile
    prepareEnvFileForProduction "$@"
    buildDocker "$@"
    startDocker
    prepareLaravel "$@"
elif [ "$1" = "up" ]; then
    startDocker
elif [ "$1" = "down" ]; then
    stopDocker
elif [ "$1" = "help" ]; then
    help
else
    echo "Invalid command"
    help
fi
