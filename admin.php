<?php
session_start();

// 检查管理员是否登录，否则跳转到登录页面
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// 全部用户文件夹路径
$userFolders = glob('user_data/*/', GLOB_ONLYDIR);

// 存储所有文件的数组
$allFiles = [];

// 遍历每个用户文件夹，收集文件信息
foreach ($userFolders as $userFolder) {
    $username = basename(rtrim($userFolder, '/'));
    $files = scandir($userFolder);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            // 构建文件信息数组
            $fileInfo = [
                'username' => $username,
                'filename' => $file,
                'filepath' => $userFolder . $file
            ];
            // 将文件信息加入总文件数组
            $allFiles[] = $fileInfo;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>File Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allFiles as $fileInfo): ?>
                <tr>
                    <td><?php echo $fileInfo['username']; ?></td>
                    <td><?php echo $fileInfo['filename']; ?></td>
                    <td><a href="download.php?file=<?php echo urlencode($fileInfo['filename']); ?>">Download</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
