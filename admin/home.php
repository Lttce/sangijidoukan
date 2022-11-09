<?php require('login-check.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ホーム画面｜産技児童館</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">
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


    <div class="registerForm">
        <h2>ホーム</h2>
        <p>
            <input type="button" class="homeButton" onclick="location.href='index.php'" value="書籍一覧">
        </p>
        <p>
            <input type="button" class="homeButton" onclick="location.href='lend.php'" value="貸出登録">
            <input type="button" class="homeButton" onclick="location.href='list.php'" value="貸出一覧">
        </p>
    </div>

    <style>
        .homeButton {
            width: 12em;
            height: 4em;
        }
    </style>

</body>

</html>