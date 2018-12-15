#!/bin/bash
cd `dirname $0`

. ./.env

cd ../..

echo ">>> remove files on server." >&1
ssh -i $SSH_KEY -p $SSH_PORT $SSH_USER@$SSH_HOST "cd $REMOTE_PATH && rm -rf $THEME/*"
echo "%%% remove file on server, success. %%%"

# Upload by scp
echo ">>> upload to remote from "themes/$THEME $SSH_USER" to "$REMOTE_PATH/$THEME >&1
scp -i $SSH_KEY -P $SSH_PORT -r themes/$THEME $SSH_USER@$SSH_HOST:$REMOTE_PATH
echo "%%% upload file to server, success. %%%"

exit
