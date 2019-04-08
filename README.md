# Slim Api Rest Aplication

Api RestFull for manage Recipes

## Configure your S.O.

Elasticsearch requires the ability to create many memory-mapped areas, then is necessary run this command (This command must be run every time you reboot your system)

    sudo sysctl -w vm.max_map_count=262144

Add this line to your /etc/hosts file.
    
    127.0.0.1       slimapp.loc

## Docker

Run this commands from the docker directory.

    docker-compose build
    
    docker-compose up -d

## Restore backup database

From your host os run
    
    curl -XPOST localhost:9200/_snapshot/backup/snapshot_1/_restore
    
## Install the Application

    docker exec -it slimp-php bash
    
    composer install
    
## Run all Test

Inside slim-php container

    docker exec -it slimp-php bash
    
    composer test

 