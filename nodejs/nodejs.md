wget http://nodejs.org/dist/v0.12.4/node-v0.12.4.tar.gz
tar -xvzf node-v0.12.4.tar.gz        
cd node-v0.12.4/
./configure --prefix=/data/apps/nodejs
make && make install

ls /data/apps/nodejs/bin/
node npm

npm install -g opener
npm install -g devtools-terminal
#npm每装一个包都需执行一次
ln -s /data/apps/nodejs/bin/* /usr/bin/