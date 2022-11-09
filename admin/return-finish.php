<?php require('login-check.php'); ?>

<?php

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>返却完了画面｜産技児童館</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">
    <style>
        p {
            text-align: center;
        }

        .returnButton {
            text-align: center;
        }
    </style>
</head>

<body class="adminBg">

    <header>
        <div class="headerInner">
            <div class="headerLeft">
                <a name="top">産技児童館</a>
            </div>
            <div class="headerCenter">
                <a href="index.php#newBook">書籍登録</a>
                <a href="index.php">書籍一覧</a>
                <a href="lend.php">貸出登録</a>
                <a href="list.php">貸出一覧</a>
            </div>
            <div class="headerRight">
                <a href="logout.php">ログアウト</a>
            </div>
        </div>
    </header>

    <div class="registerList">
        <h2>返却完了</h2>
        <p>本の返却が完了しました。</p>
        <p>
            <input type="button" value="貸出一覧へ" class="registerButton" onclick="location.href='list.php'">
        </p>
    </div>
</body>

</html>