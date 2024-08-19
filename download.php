<?php
session_start();

// 检查用户是否登录，否则跳转到登录页面
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// 检查文件参数
if (isset($_GET['file'])) {
    $filename = $_GET['file'];
    $filepath = "user_data/$username/$filename";

    // 检查文件是否存在
    if (file_exists($filepath)) {
        // 设置HTTP头，提示浏览器下载文件
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filepath);
        exit;
    } else {
        die('文件不存在');
    }
} else {
    die('无效的请求');
}
?>
