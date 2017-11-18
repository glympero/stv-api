stv_api
=======

### Requirements
  - PHP
  - MySql
  - Symfony
  
### Configure our database settings
  - Open app/config/parameters.yml and adjust the database settings.
   
### composer install
  - Install dependencies.
  
### php bin/console doctrine:database:create
  - Create database using the information added to parameters.yml
  
### php bin/console doctrine:schema:update --force
  - Generate tables from Entity class.
  
 ### php bin/console csv:import
  - This is a custom created service that reads all files in src/AppBundle/Command/Data folder and imports csv to database. (src/AppBundle/Command/CsvImportCommand.php)
  
### php bin/console server:run
   - Start Application
