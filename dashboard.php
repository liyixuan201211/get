<?php
session_start();

// 检查用户是否登录，否则跳转到登录页面
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// 管理员权限检查（假设管理员用户名为 admin）
$is_admin = ($username === 'admin');

// 用户文件夹路径
$userFolder = "user_data/$username/";

// 创建用户文件夹（如果不存在）
if (!file_exists($userFolder)) {
    mkdir($userFolder, 0777, true);
}

// 处理上传文件
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // 检查上传是否成功
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = basename($file['name']);
        $destination = $userFolder . $filename;

        // 移动上传的文件到用户文件夹
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $uploadMessage = '文件上传成功';
        } else {
            $uploadError = '文件上传失败';
        }
    } else {
        $uploadError = '上传出错，请重试';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Welcome, <?php echo $username; ?></h2>
    <?php if ($is_admin): ?>
        <p><a href="admin.php">Admin Panel</a></p>
    <?php endif; ?>
    <a href="logout.php">Logout</a><br><br>

    <!-- 文件上传表单 -->
    <form method="post" enctype="multipart/form-data">
        <label>Upload File: <input type="file" name="file"></label>
        <input type="submit" value="Upload">
        <?php
        if (isset($uploadMessage)) {
            echo "<p>$uploadMessage</p>";
        }
        if (isset($uploadError)) {
            echo "<p>$uploadError</p>";
        }
        ?>
    </form>

    <hr>

    <!-- 用户文件列表 -->
    <h3>Your Files:</h3>
    <ul>
        <?php
        $files = scandir($userFolder);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo "<li><a href='download.php?file=" . urlencode($file) . "'>$file</a></li>";
            }
        }
        ?>
    </ul>
</body>
</html>
