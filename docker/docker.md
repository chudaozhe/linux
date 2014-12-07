运行一个容器[如果此容器镜像不存大则自动下载，这里会下载docker.cn/docker/centos镜像]

docker run -i -t docker.cn/docker/centos /bin/bash

[root@5d3b3f1d93f2 /]# ls
[root@5d3b3f1d93f2 /]# touch hehe.txt

保存容器更改：
docker commit 5d3[镜像id 即登录容器后显示的root@xxx,xxx部分不必写全] cwweb:v1

运行已保存过的容器[id会变化]
docker run -i -t cwweb:v1 /bin/bash
[root@22a519c163e4 /]# whereis httpd

镜像列表：
[root@fedora cw]# docker images
REPOSITORY                TAG                 IMAGE ID            CREATED              VIRTUAL SIZE
cwweb                     v2                  5f4f44bca20a        About a minute ago   423.7 MB
cwweb                     v1                  62c5ef79ea60        5 minutes ago        423.7 MB
docker.cn/docker/centos   centos7             ae0c2d0bdc10        4 weeks ago          224 MB
docker.cn/docker/centos   latest              ae0c2d0bdc10        4 weeks ago          224 MB

删除一个容器：
docker rmi 镜像Id

----------------------------Fedora INSTALL------------------------
在Fedora中已经提供docker-io包了

如果你已经安装了(不相关)的docker包，它会跟docker-io有冲突，有一个错误报告，如果想继续安装docker-io，请先删除docker.

sudo yum -y remove docker

在Fedora 20版本之后，wmdocker包与docker-io提供相同的功能，但是也不会冲突

sudo yum -y install wmdocker
sudo yum -y remove docker

开始安装docker-io包在我们的主机上

sudo yum -y install docker-io

升级docker-io包

sudo yum -y update docker-io

现在已经安装好了，让我们启动docker进程

sudo systemctl start docker

如果我们想开机启动，我们需要

sudo systemctl enable docker

现在测试一下是否正常工作了

sudo docker run -i -t fedora /bin/bash

好了，现在你可以继续做hello word的例子
