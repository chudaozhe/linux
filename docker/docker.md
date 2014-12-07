docker run -i -t docker.cn/docker/centos /bin/bash

[root@5d3b3f1d93f2 /]# ls

docker commit 635[] cwweb:v1
docker rmi imagesId

[root@fedora cw]# docker images
REPOSITORY                TAG                 IMAGE ID            CREATED              VIRTUAL SIZE
cwweb                     v3                  67fc84a2d72f        51 seconds ago       423.7 MB
cwweb                     v2                  5f4f44bca20a        About a minute ago   423.7 MB
cwweb                     v1                  62c5ef79ea60        5 minutes ago        423.7 MB
docker.cn/docker/centos   centos7             ae0c2d0bdc10        4 weeks ago          224 MB
docker.cn/docker/centos   latest              ae0c2d0bdc10        4 weeks ago          224 MB
[root@fedora cw]# 

运行已有镜像[id会不一样]
docker run -i -t cwweb:v1 /bin/bash
[root@22a519c163e4 /]# whereis httpd