#!/bin/bash
# Version 2016-06-02
# USAGE: ./backup-database.sh -u root -p passw0rd -d my_db -h localhost

# Defaults
HOST="localhost"
DIRECTORY="db-backups"

mkdir -p $DIRECTORY
cd $DIRECTORY

while [[ $# > 1 ]]
do
key="$1"

case $key in
    -d|--database)
    DATABASE="$2"
    shift # past argument
    ;;
    -u|--user)
    USER="$2"
    shift # past argument
    ;;
    -p|--password)
    PASSWORD="$2"
    shift # past argument
    ;;
    -h|--host)
    HOST="$2"
    shift # past argument
    ;;
esac
shift # past argument or value
done

location=$DATABASE-`date +%Y%m%d_%H%M%S`.db

mysqldump -u$USER -p$PASSWORD --protocol=tcp --host=$HOST $DATABASE > $location
rm -rf $DATABASE-latest.db
cp $location $DATABASE-latest.db
gzip $location
find . -iname '*.gz' -mtime +7 -exec rm {} \;
