#!/bin/bash
set -e
cd "$(dirname "${BASH_SOURCE[0]}")"

ssh_host="185.178.45.21"
ssh_user="bitrix"
ssh_port="2221"
ssh_pass="Ghbdtn<bnhbrc2019"
mysql_host="localhost"
mysql_user="matilda"
mysql_pass="GhbdtnVfnbkmlf2019"
mysql_db="dbreg"
mysql_dump_path='/home/bitrix/dump.sql.gz'
remote_upload_url="/home/bitrix/ext_www/reg.kubsau.ru/upload/"
remote_bitrix_url="/home/bitrix/ext_www/reg.kubsau.ru/bitrix/"
local_upload_url="pdo/upload/"
local_bitrix_url="pdo/bitrix/"

function makeDumpOnServer() {
  sshpass -p $ssh_pass ssh -p2221 -o StrictHostKeyChecking=no -T $ssh_user@$ssh_host <<-SSH
    if [ -f dump.sql.gz ]; then
        rm $mysql_dump_path
    fi
    mysqldump -h$mysql_host -u$mysql_user -p'$mysql_pass' $mysql_db | gzip - > $mysql_dump_path
SSH
  return $?
}

function removeDumpFromServer() {
  sshpass -p $ssh_pass ssh -p 2221 -o StrictHostKeyChecking=no -T $ssh_user@$ssh_host <<-SSH
    if [ -f dump.sql.gz ]; then
        rm $mysql_dump_path
    fi
SSH
  return $?
}

function getDumpFromServer() {
  sshpass -p $ssh_pass rsync -rzclEt -e 'ssh -p 2221' --progress $ssh_user@$ssh_host:$mysql_dump_path dump.sql.gz
    return $?
}

function loadDumpToDocker() {
  if [ -f dump.sql.gz ]; then
    docker/dctl.sh db import containers/mysql/drop_all_tables.sql
    gunzip -c dump.sql.gz | docker/dctl.sh db import -
  fi
  return $?
}

function syncBitrix() {
  sshpass -p $ssh_pass rsync -rzclEt -e 'ssh -p 2221' --progress --delete-after --exclude='web_release' --exclude='backup' --exclude='cache' --exclude='cache' --exclude='.settings_extra.php' --exclude='.settings.php' --exclude='php_interface' $ssh_user@$ssh_host:$remote_bitrix_url $local_bitrix_url
  return $?
}

function syncDb() {
  makeDumpOnServer
  getDumpFromServer
  removeDumpFromServer
  loadDumpToDocker
}

function syncUpload() {
  sshpass -p $ssh_pass rsync -rzclEt -e 'ssh -p 2221' --progress --delete-after --exclude='*.gz' $ssh_user@$ssh_host:$remote_upload_url $local_upload_url
  return $?
}

if [ $# -eq 0 ]; then
    echo "Menu:"
    echo "sync upload"
    echo "sync db"
    echo "sync files"
    echo "sync bitrix"
    echo "sync all"
fi

if [ "$1" == "sync" ]; then
  if [ "$2" == "upload" ]; then
    syncUpload
  fi
  if [ "$2" == "db" ]; then
    syncDb
  fi
  if [ "$2" == "bitrix" ]; then
    syncBitrix
  fi
  if [ "$2" == "all" ]; then
    syncDb
    syncUpload
    syncBitrix
  fi
  if [ "$2" == "files" ]; then
    syncUpload
    syncBitrix
  fi
fi