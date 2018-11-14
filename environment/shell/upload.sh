#!/bin/bash
cd `dirname $0`

. ./.env

cd ..

echo "+ Remove files on server." >&1
ssh -i $SSH_KEY -p $SSH_PORT $SSH_USER@$SSH_HOST "cd $REMOTE_PATH && rm -rf $THEME/*"

# Upload by scp
echo "+ Upload to remote from "themes/$THEME $SSH_USER" to "$REMOTE_PATH/$THEME >&1
scp -i $SSH_KEY -P $SSH_PORT -r themes/$THEME $SSH_USER@$SSH_HOST:$REMOTE_PATH/$THEME

echo "+ Complete process" >&1
exit
