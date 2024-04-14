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
    echo "Installing Composer dependencies..."
    docker-compose -f "$DOCKER_COMPOSE_PATH" exec php composer install
}

prepareLaravel() {
    echo "Preparing Laravel..."
    docker-compose -f "$DOCKER_COMPOSE_PATH" exec php chmod -R 777 ./storage
    composerInstall
    docker-compose -f "$DOCKER_COMPOSE_PATH" exec php sh -c '
        php artisan key:generate &&
        php artisan cache:clear &&
        php artisan route:clear &&
        php artisan config:clear &&
        php artisan view:clear &&
        php artisan storage:link &&
        php artisan migrate:fresh --seed'
}

help() {
    echo "Usage: ./deployer.sh [command]"
    echo "Commands:"
    echo "  magic: Build, start, and prepare Laravel (Useful arg: no-cache)"
    echo "  up: Start all services"
    echo "  down: Stop all services"
    echo "  help: Show available commands"
}

if [ "$1" = "magic" ]; then
    showWelcomeMessage
    copyEnvFile
    buildDocker "$@"
    startDocker
    prepareLaravel
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
