<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Chỉ tài khoản 管理 mới có thể truy cập trang này
if ($user['department'] !== "管理") {
    header("Location: form.php");
    exit();
}

// Handle delete - 管理 user can delete any employee
if (isset($_GET['delete_id'])) {
    $delete_id = trim($_GET['delete_id']);
    if (!empty($delete_id)) {
        $stmt = $conn->prepare("DELETE FROM employee WHERE employee_id = ?");
        $stmt->bind_param("s", $delete_id);
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $conn->commit();
            $conn->query("FLUSH PRIVILEGES;");
            echo '<p class="success">';
            echo "データベースが更新されました！\n";
            echo '</p>';
            
        } else {
            echo '<p class="fail">';
            echo "エラーが発生しました！\n";
            echo '</p>';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社員一覧画面 | 安否確認システム</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <p class="welcome">こんにちは、<strong><?= $user['full_name'] ?></strong>さん！</p>
    <div class="container">

        <h1>安否確認システム</h1>
        <h2>社員一覧画面</h2>

        <table>
            <tr>
                <th>社員番号</th>
                <th>氏名</th>
                <th>安否状況</th>
                <th>権限</th>
                <th>取り消し</th>
            </tr>

            <?php
            $sql = "SELECT employee_id, full_name, safety_status, department FROM employee ORDER BY employee_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Set color based on safety_status
                    if ($row['safety_status'] == "無事") {
                        $color = "green";
                    } elseif ($row['safety_status'] == "ケガがあり") {
                        $color = "yellow";
                    } elseif ($row['safety_status'] == "出社不可") {
                        $color = "red";
                    } else {
                        $color = "default";
                    }

                    echo "<tr>";
                    echo "<td>" . ($row['employee_id']) . "</td>";
                    echo "<td>" . ($row['full_name']) . "</td>";
                    echo "<td class='" . $color . "'>" . ($row['safety_status']) . "</td>";
                    echo "<td>" . ($row['department']) . "</td>";
                    if ($row['department'] === "一般") {
                        echo "<td><a href='?delete_id=" . $row['employee_id'] . "' onclick='return confirm(\"本当に削除しますか？\")'>✖</a></td>";
                    } else {
                        echo "<td></td>";
                    }
                    // echo "<td><a href='?delete_id=" . $row['employee_id'] . "' onclick='return confirm(\"本当に削除しますか？\")'>✖</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>データがありません</td></tr>";
            }
            ?>
        </table>

        <div class="link-area">
            <p><a href="new_employee.php">新規社員登録</a></p>
            <p><a href="form.php">フォーム戻る</a></p>
            <p><a href="logout.php">ログアウト</a></p>
        </div>
    </div>

</body>

</html>