<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

foreach ($_SERVER as &$value) {
    $prefix = "/image-upload";
    $prefixLength = strlen($prefix);
    if (substr($value, 0, $prefixLength) === $prefix) {
        $value = substr($value, $prefixLength, strlen($value) - $prefixLength);
    }
}

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

$baseHref = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/image-upload';

// 执行应用并响应
$result = Container::get('app')->bind('index')->run();
if (get_class($result) === 'think\response\Redirect' && $result->data[0] === '/') $result->data = '/image-upload' . $result->data;
else if (get_class($result) === 'think\Response' && $result->contentType === 'text/html') {
    // foreach (array("href", "link", "src") as $prop) {
    //     $result->data = str_replace("$prop=\"/", "$prop=\"/image-upload/", $result->data);
    // }
    $result->data = str_replace("\"/image-upload/", "\"/", $result->data);
    $result->data = str_replace("\"/", "\"/image-upload/", $result->data);

    $result->data = str_replace("'/image-upload/", "'/", $result->data);
    $result->data = str_replace("'/", "'/image-upload/", $result->data);

    $result->data = str_replace("\"" . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/image-upload', "\"" . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/', $result->data);
    $result->data = str_replace("\"" . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'], "\"" . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/image-upload', $result->data);
}
$result->send();
