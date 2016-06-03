#!/bin/bash
# Version 2016-06-02

# Defaults
BUCKET="database-snapshots"
DIRECTORY="db-backups"
BUCKET_PATH=""

while [[ $# > 1 ]]
do
key="$1"

case $key in
    -b|--bucket)
    BUCKET="$2"
    shift # past argument
    ;;
    -p|--path)
    BUCKET_PATH="$2"
    shift # past argument
    ;;
    -d|--directory)
    DIRECTORY="$2"
    shift # past argument
    ;;
esac
shift # past argument or value
done

/usr/local/bin/aws s3 sync $DIRECTORY s3://$BUCKET/$BUCKET_PATH
