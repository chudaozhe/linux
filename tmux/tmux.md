yum install libevent-devel ncurses-devel
wget http://downloads.sourceforge.net/tmux/tmux-1.9a.tar.gz
解决libevent版本过旧的提示：
control.c: In function ‘control_callback’:
control.c:64: warning: implicit declaration of function ‘evbuffer_readln’
control.c:64: error: ‘EVBUFFER_EOL_LF’ undeclared (first use in this function)
control.c:64: error: (Each undeclared identifier is reported only once
control.c:64: error: for each function it appears in.)
make: *** [control.o] Error 1

指定新版libevent的位置
CFLAGS="-I/data/apps/libs/include" LDFLAGS="-L/data/apps/libs/lib" ./configure --prefix=/data/apps/tmux
make && make install

[root@mail tmux-1.9a]# tmux new -s ali
tmux: error while loading shared libraries: libevent-2.0.so.5: cannot open shared object file: No such file or directory
[root@mail tmux-1.9a]# ln -s /usr/local/lib/libevent-2.0.so.5 /usr/lib64/
#启动创建会话
tmux
#创建指定名称的会话：cw123
tmux new-s cw123
#在后台创建指定名称的会话：cw123
tmux new -s cw123 -d
#列出会话
[root@mail ~]# tmux ls
1: 1 windows (created Thu Mar  5 10:07:47 2015) [80x24] (attached)
cw123: 1 windows (created Thu Mar  5 10:07:09 2015) [105x17] (attached)
#进入回话0
[root@mail ~]# tmux attach -t 0
#进入回话cw123[root@mail ~]# tmux attach -t cw123

#进入一个会话后新建窗口
ctrl-b c 
            ctrl-b % 纵向分隔窗口   >可以用ctrl-b 方向键在子窗口间切换 || ctrl-b alt-方向键 一下一下的调整子窗口大小|| ctrl+b q显示子窗口编号


#退出tumx，并保存当前会话，这时，tmux仍在后台运行，可以通过tmux attach进入 到指定的会话
ctrl-b d
#切换窗口
ctrl-b n

