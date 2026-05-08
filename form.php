<?php
session_start();
require_once 'db_connect.php';

// Nếu người dùng vừa nhấn nút đăng nhập từ login.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_account = $_POST['account'];
    $user_password = $_POST['password'];

    // Lấy thêm cột department để hiển thị Position
    $sql = "SELECT employee_id, full_name, account, password, department, safety_status FROM employee WHERE account = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_account);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        if ($user_password === $user_data['password']) {
            $_SESSION['user'] = $user_data;
        } else {
            echo "<script>alert('間違っていますね！'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('不存在アカウント！'); window.location.href='login.php';</script>";
        exit();
    }
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>安否報告 | 安否確認システム</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <p class="welcome">こんにちは、<strong><?= $user['full_name'] ?></strong>さん！</p>

    <div class="container">
        <h1>安否確認システム</h1>
        <h2>安否報告画面</h2>

        <p>名前：<?= $user['full_name'] ?></p>
        <p>ポジション：<?= $user['department'] ?></p>
        <form action="complete.php" method="POST">
            <input type="hidden" name="employee_id" value="<?= $user['employee_id'] ?>">
            <div class="form-group">
                <label>現在の状況を選んでください</label>
                <select name="safety_status" required>
                    <?php

                    $query = "SELECT id, safety_status FROM safety_options ORDER BY id ASC";
                    $result_options = $conn->query($query);

                    if ($result_options && $result_options->num_rows > 0) {
                        while ($row = $result_options->fetch_assoc()) {

                            echo '<option value="' . ($row['safety_status']) . '">'
                                . $row['safety_status'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit">送信</button>
        </form>
    </div>

    <div class="link-area">
        <?php
        if ($user['department'] === "管理") {
            echo '<p><a href="list_employee.php">従業員一覧</a></p>';
        }
        ?>
        <p><a href="logout.php">ログアウト</a></p>
    </div>

</body>

</html>