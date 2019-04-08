# Slim Api Rest Aplication

Api RestFull for manage Recipes

## Configure your S.O.

* Elasticsearch requires the ability to create many memory-mapped areas, then is necessary run this command (This command must be run every time you reboot your system)

        sudo sysctl -w vm.max_map_count=262144

make it persistent:
    
        nano /etc/sysctl.conf
        vm.max_map_count=262144

* Add this line to your /etc/hosts file.
    
    127.0.0.1       slimapp.loc

## Docker

* Give permissions to logs folder
    
        chmod -R 0755 code/slimApp/logs
    

* Run this commands from the docker directory.

        docker-compose build
    
        docker-compose up -d

## Restore backup database

    docker exec -it slimp-php bash
        
    (import) elasticdump   --output=http://slim-dbserver:9200/test  --input=backup/recipe.json   --type=data
    
    (export) elasticdump   --input=http://slim-dbserver:9200/test  --output=backup/recipe.json
    
## Install the Application

    docker exec -it slimp-php bash
        
    composer install
    
    composer dump-autoload -o
    
## Run all Test

    docker exec -it slimp-php bash
    
    composer test

## Documentation
 
   * http://slimapp.loc/swagger/doc
   
## Api URLs
    For check use postman or curl
    
    * GET    http://slimapp.loc/recipe/{id]
    * PUT    http://slimapp.loc/recipe/{id]
    * DELETE http://slimapp.loc/recipe/{id]
    * POST   http://slimapp.loc/recipe
        
        
    - Search:
    * POST   http://slimapp.loc/recipe/search/query_string
    
        Post Params => 
            query = "Banana Cake"
        
        
        query accept all words wich you want to search separated by blank space
        
    * POST   http://slimapp.loc/recipe/search/match
    
        Post Params => 
            Title = "Banana"
        search in Title param 'Banana'
        
    * POST   http://slimapp.loc/recipe/search/match_all
        
        Return all results stored