<?php
//注意 这里的 '/file'并不是linux 根目录下的file文件夹
//真实路径为'/www/test.tool.zip',详见conf.d/local.conf
$path = "/file/tool.zip";
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($path).'"');
header('X-Accel-Redirect: '. $path);
exit;
