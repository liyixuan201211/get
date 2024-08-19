<?php
session_start();

// 模拟用户数据库
$users = [
'liyixuan' => 'liyixuan',
'pengluming' => 'pengluming',
'baoyufan' => 'baoyufan',
'jintingyu' => 'jintingyu',
'lixintian' => 'lixintian',
'jiayanlin' => 'jiayanlin',
'wangjunxi' => 'wangjunxi',
'xuchunqing' => 'xuchunqing',
'zhangmingqi' => 'zhangmingqi',
'wangminyan' => 'wangminyan',
'linrun' => 'linrun',
'libangzheng' => 'libangzheng',
'zhangzhekai' => 'zhangzhekai',
'admin' => 'liyixuan15'
];

// 处理登录表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 验证用户名和密码
    if (isset($users[$username]) && $users[$username] === $password) {
        // 记录用户登录状态
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = '用户名或密码错误';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="">
        <label>Username: <input type="text" name="username"></label><br>
        <label>Password: <input type="password" name="password"></label><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
