<!-- ログイン画面 -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | 安否確認システム</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <div class="container small">
        <h1>安否確認システム</h1>
        <h2>ログイン</h2>

        <form action="form.php" method="POST">
            <div class="form-group">
                <label for="account">アカウント</label>
                <input type="text" name="account" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">ログイン</button>
        </form>

    </div>

    <script src="app.js"></script>
</body>

</html>