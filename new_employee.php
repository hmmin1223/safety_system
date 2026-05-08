<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';
 
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
 
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = trim($_POST['employee_id']);
    $full_name = trim($_POST['full_name']);
    $account = trim($_POST['account']);
    $password = trim($_POST['password']);
    $department = ($_POST['role'] == 'admin') ? '管理' : '一般';
 
    // Validation
    $errors = [];
    if (empty($employee_id)) $errors[] = "社員番号を入力してください";
    if (empty($full_name)) $errors[] = "氏名を入力してください";
    if (empty($account)) $errors[] = "アカウントを入力してください";
 
    // Check if employee_id or account already exists
    if (!empty($employee_id)) {
        $stmt = $conn->prepare("SELECT employee_id FROM employee WHERE employee_id = ?");
        $stmt->bind_param("s", $employee_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) $errors[] = "社員番号が既に存在します";
        $stmt->close();
    }
    if (strlen($employee_id) > 4) $errors[] = "社員番号は数文字4桁まで入力してください";
 
    if (!empty($account)) {
        $stmt = $conn->prepare("SELECT account FROM employee WHERE account = ?");
        $stmt->bind_param("s", $account);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) $errors[] = "アカウントが既に存在します";
        $stmt->close();
    }
 
    if (empty($errors)) {
        // Insert new employee
        $sql = "INSERT INTO employee (employee_id, full_name, department, account, password, safety_status, updated_at) VALUES (?, ?, ?, ?, ?, '未回答', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $employee_id, $full_name, $department, $account, $password);
 
        if ($stmt->execute()) {
            $conn->commit();
            $conn->query("FLUSH PRIVILEGES;");
            echo "<div class='success'>新規社員を登録しました！</div>";
        } else {
            echo "<div class='fail'> 登録エラー: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<div class='fail'>" . $error . "</div>";
        }
    }
}
?>
 
 
 
<!DOCTYPE html>
<html lang="ja">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規社員登録 | 安否確認システム</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
 
<body>
    <p class="welcome">こんにちは、<strong><?= $user['full_name'] ?></strong>さん！</p>
 
    <div class="container">
        <h1>安否確認システム</h1>
        <h2>新規社員登録</h2>
 
        <form action="new_employee.php" method="POST">
 
            <div class="form-group">
                <label>社員番号</label>
                <p><small>数文字4桁まで入力してください
                    </small>
                </p>
                <input type="text" name="employee_id" placeholder="例：a000" required>
            </div>
 
            <div class="form-group">
                <label>氏名</label>
                <input type="text" name="full_name" placeholder="例：山田 太郎" required>
            </div>
 
            <div class="form-group">
                <label>アカウント</label>
                <p><small>管理者のアカウントでは　example.ss　ようにしてください
                        <br>
                        一般社員のアカウントでは　example.stu　ようにしてください
                    </small>
                </p>
                <input type="text" name="account" required>
            </div>
 
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" placeholder="8文字以上で入力" required>
            </div>
 
            <div class="form-group">
                <label>権限</label><br>
                <input type="radio" name="role" value="general" checked>
                一般社員
                <br>
                <input type="radio" name="role" value="admin">
                管理者
            </div>
 
            <button type="submit">登録する</button>
 
        </form>
 
        <div class="link-area">
            <p><a href="list_employee.php">戻る</a></p>
        </div>
 
    </div>
 
</body>
 
</html>