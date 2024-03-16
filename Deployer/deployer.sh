DOCKER_COMPOSE_PATH=../Docker/docker-compose.yml

magic() {
    buildDocker
    stopDocker
    startDocker
    prepareLaravel
}

buildDocker() {
    echo "Docker building..."
    docker-compose -f $DOCKER_COMPOSE_PATH build --no-cache
    echo "Docker build successfully"
}

startDocker() {
    echo "Docker starting..."
    docker-compose -f $DOCKER_COMPOSE_PATH up -d
    echo "Docker started successfully"
}

stopDocker() {
    echo "Docker stopping..."
    docker-compose -f $DOCKER_COMPOSE_PATH down
    echo "Docker stopped successfully"
}

composerInstall() {
    echo "Composer installing..."
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm composer install
    echo "Composer installed successfully"
}

prepareLaravel() {
    echo "Preparing Laravel..."

    composerInstall
    npmInstall
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php cp .env.example .env
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan migrate:fresh --seed
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm php chmod -R 777 ./storage
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan view:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan view:cache
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan config:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan config:cache
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan cache:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan route:clear
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm artisan storage:link

    echo "Laravel prepared successfully"
}

npmInstall() {
    echo "Npm installing..."
    docker-compose -f $DOCKER_COMPOSE_PATH run --rm npm install
    echo "Npm installed successfully"
}

help() {
    echo "Usage: deployer.sh [command]"
    echo "Commands:"
    echo "  magic: Build all app"
    echo "  build: Build docker"
    echo "  start: Start docker"
    echo "  stop: Stop docker"
}

if [ "$1" = "magic" ]; then
    magic
elif [ "$1" = "build" ]; then
    buildDocker
elif [ "$1" = "start" ]; then
    startDocker
elif [ "$1" = "stop" ]; then
    stopDocker
elif [ "$1" = "help" ]; then
    help
else
    echo "Invalid command"
    help
fi
