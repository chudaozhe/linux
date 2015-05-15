#!/bin/bash
#example: sh rsa_addPublicKey.sh "ssh-rsa AAAAB3NzaC1yc2EAAAEfRrLbw== cw@work"
CONTENT=$1;
DIR=$2;
FILE=$3;

if [ ! -n "${DIR}" ]
then
DIR=~/.ssh;
fi;

if [ ! -n "${FILE}" ]
then
FILE="authorized_keys";
fi;

if [ ! -n "${CONTENT}" ]
then
echo "error-- example: sh rsa_addPublicKey.sh publicKey";
exit 0;
fi;

if [ ! -d ${DIR} ]
then
  mkdir ${DIR};
  chmod 700 ${DIR};
fi;

if [ ! -e "${DIR}/${FILE}" ]
then
  touch "${DIR}/${FILE}";
  chmod 600 "${DIR}/${FILE}";
fi;

echo $CONTENT >> "${DIR}/${FILE}";
echo "ok";
