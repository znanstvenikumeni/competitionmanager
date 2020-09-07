# Installing CompetitionManager

## Creating the database
Use createDB.sql to bootstrap a database for CompetitionManager.

## Configuring CM
```
mkdir storage
mv config.sample.json storage/config.json
mv keys.sample.json storage/keys.json
cd storage
mkdir logs
touch logs/security.log
```

## Use Composer to install dependecies
```
composer install
```

## Create an admin account
You can do so by changing the aai of a non-admin account or by changing the admin domain.