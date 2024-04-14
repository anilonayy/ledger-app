DOCKER_COMPOSE_PATH=../docker-compose.yml

magic() {
    showWelcomeMessage
    buildDocker
    stopDocker
    startDocker
    prepareLaravel
}

showWelcomeMessage() {
    cat ./welcome_prompt.txt
}

buildDocker() {
    if [ ! -f "../.env" ]; then
        echo "Creating env file for env $APP_ENV"
        cp ../.env.example ../.env
    else
        echo "env file exists."
    fi


    echo "Docker building..."
    if [ "$2" = "no-cache" ]; then
        docker-compose -f $DOCKER_COMPOSE_PATH build --no-cache
    else
        docker-compose -f $DOCKER_COMPOSE_PATH build
    fi
}

startDocker() {
    echo "Docker starting..."
    docker-compose -f $DOCKER_COMPOSE_PATH up -d
}

stopDocker() {
    echo "Docker stopping..."
    docker-compose -f $DOCKER_COMPOSE_PATH down
}

composerInstall() {
    echo "Composer installing..."
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm composer install
}

prepareLaravel() {
    echo "Preparing Laravel..."

    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php chmod -R 777 ./storage

    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan key:generate
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan cache:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan route:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan config:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan view:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan storage:link
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php php artisan migrate:fresh --seed
}

npmInstall() {
    echo "Npm installing..."
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php npm install
}

help() {
    echo "Usage: ./deployer.sh [command]"
    echo "Commands:"
    echo "  magic: Build all app (Useful arg: no-cache)"
    echo "  up: Start all services"
    echo "  down: Stop all services"
    echo "  help: Show available commands"
}

if [ "$1" = "magic" ]; then
    magic
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
