#!/bin/bash
cd `dirname $0`
# load .env settings
. ./.env
# move repository root
cd ..
## remove current themes files on remote server.
echo ">>> remove files on server."
ssh -i $SSH_KEY -p $SSH_PORT $SSH_USER@$SSH_HOST "cd $REMOTE_PATH && rm -rf $THEME/*"
echo ">>> remove file on server, success. "
# upload themes files by scp to remote server.
echo ">>> upload file to server from "themes/$THEME" to "$REMOTE_PATH/$THEME >&1
scp -i $SSH_KEY -P $SSH_PORT -r themes/$THEME $SSH_USER@$SSH_HOST:$REMOTE_PATH
echo ">>> upload file to server, success. "
exit
