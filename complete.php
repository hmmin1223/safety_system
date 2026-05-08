<?php
session_start();

require_once 'db_connect.php';

//　ログイン確認
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = trim($_POST['employee_id']);
    $status = trim($_POST['safety_status']);


    if (!empty($emp_id) && !empty($status)) {
        // update mysql?
        $sql = "UPDATE employee SET safety_status = ?, updated_at = NOW() WHERE employee_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $status, $emp_id);

        if ($stmt->execute()) {
            echo '<p class="success">';
            echo "データベースが更新されました！\n";
            echo '</p>';

            if ($stmt->affected_rows > 0) {
                $conn->commit();
                $_SESSION['user']['safety_status'] = $status;
            }
            $stmt->close();
        } else {
            echo '<p class="fail">';
            echo "エラーが発生しました！\n";
            echo '</p>';
        }
    }
}
$user = $_SESSION['user'];
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>報告完了 | 安否確認システム</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <p class="welcome">こんにちは、<strong><?= $user['full_name'] ?></strong>さん！</p>

    <div class="container">
        <h1>安否確認システム</h1>
        <h2>報告完了</h2>

        <p class="message">安否報告が完了しました。</p>
        <p class="message">ご協力ありがとうございます。</p>

        <p class="message">名前：<?= $user['full_name'] ?></p>
        <p class="message">ポジション：<?= $user['department'] ?></p>
        <p class="message">安否状況：<?= $user['safety_status'] ?></p>

    </div>
    <div class="link-area">
        <p><a href="form.php">フォーム戻る</a></p>
        
        <p><a href="logout.php">ログアウト</a></p>
    </div>
</body>

</html>

<?php
// Debug - Xem dữ liệu nhận được
$conn->query("FLUSH PRIVILEGES;");
?>