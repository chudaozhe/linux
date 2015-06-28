用户访问http://c.cuiwei.net(172.16.1.195),自动负载均衡到172.16.1.160、172.16.1.174两台服务器

前端转发：
172.16.1.195

后端真实服务器
172.16.1.160
172.16.1.174

配置前端转发(172.16.1.195),并通过8080端口提供web服务:
1、vi nginx.conf
http {
................
    #tcp_nopush和tcp_nodely两个指令设置为on，用于防止网络阻塞
    tcp_nopush on;
    tcp_nodelay on;

    #upstream 可以定义多组，在server里边被proxy
    upstream c_cuiwei_net
    {
        server 172.16.1.160:80 weight=1 max_fails=2 fail_timeout=30s;
        server 172.16.1.174:80 weight=1 max_fails=2 fail_timeout=30s;
        server 172.16.1.195:8080 weight=1 max_fails=2 fail_timeout=30s;
        ip_hash;
    }

    upstream d_cuiwei_net
    {
        server 172.16.1.1:80 weight=1 max_fails=2 fail_timeout=30s;
        server 172.16.1.2:80 weight=1 max_fails=2 fail_timeout=30s;
        server 172.16.1.3:80 weight=1 max_fails=2 fail_timeout=30s;
        ip_hash;
    }

2、vi conf.d/default.conf
server {
    listen       80;
    server_name  c.cuiwei.net;
    ................
    location / {
        proxy_pass   http://c_cuiwei_net;
        include conf.d/proxy.md;
    }
    
vi conf.d/default8080.conf
server {
         listen       8080;
         server_name  localhost;
         location / {
            root   /usr/share/nginx/html;
            index  index.html index.htm;
         }
     }

后端真实服务器 普通配置就行

附：
http://blog.chinaunix.net/uid-26284395-id-3087894.html
http://www.osyunwei.com/archives/3795.html
http://www.it165.net/admin/html/201305/1221.html
http://blog.chinaunix.net/uid-26393988-id-3333067.html
http://os.51cto.com/art/201202/317175.htm
