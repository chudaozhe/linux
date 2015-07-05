http://dl.google.com/android/android-sdk_r24.3.3-linux.tgz

#解压加环境变量
vi ~/.bashrc
JAVA_HOME=/data/apps/jdk
export PATH=$PATH:$JAVA_HOME

ANDROID_HOME=/data/apps/android-sdk
export PATH=$PATH:$ANDROID_HOME
export PATH=$PATH:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools

配置代理步骤
启动 Android SDK Manager ，打开主界面，
./tools/android

依次选择「Tools」、「Options...」，弹出『Android SDK Manager - Settings』窗口；
在『Android SDK Manager - Settings』窗口中，在「HTTP Proxy Server」和「HTTP Proxy Port」输入框内填入mirrors.neusoft.edu.cn和80，并且选中「Force https://... sources to be fetched using http://...」复选框。设置完成后单击「Close」按钮关闭『Android SDK Manager - Settings』窗口返回到主界面；
依次选择「Packages」、「Reload」。
由于某些网络接入商进行了劫持，会弹出用户认证界面无法使用，和本镜像服务器配置无关。


#构建项目
http://gradle.org/gradle-download/
https://services.gradle.org/distributions/gradle-2.4-all.zip

ln -s /data/apps/gradle/bin/* /usr/bin


ADT(Eclipse关联Android SDK)
http://developer.android.com/sdk/installing/installing-adt.html
离线安装包
https://dl.google.com/android/ADT-23.0.6.zip
