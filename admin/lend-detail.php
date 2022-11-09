<?php require('login-check.php'); ?>

<?php
//どのidの記事を取得するか
//idが存在してそれが数字だったら
if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $books = $db->prepare('SELECT * FROM lending WHERE id=?');
    $books->execute(array($id));
    $book = $books->fetch();
} else {
    header('Location: list.php');
    exit();
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>登録詳細｜産技児童館</title>
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
        <h2>貸出詳細</h2>
        <table class="detailTable">
            <tr>
                <th>貸出番号</th>
                <td><?php echo $book['id']; ?></td>
            </tr>
            <tr>
                <th>書籍名</th>
                <td><?php echo $book['title']; ?></td>
            </tr>
            <tr>
                <th>貸出日</th>
                <td><?php echo $book['date']; ?></td>
            </tr>
            <tr>
                <th>返却日</th>
                <td><?php echo $book['returndate']; ?></td>
            </tr>
            <tr>
                <th>児童名</th>
                <td><?php echo $book['name']; ?></td>
            </tr>
            <tr>
                <th>住所</th>
                <td><?php echo $book['address']; ?></td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td><?php echo $book['birthday']; ?></td>
            </tr>
        </table>
        <p>
            <input class="registerButton" type="button" value="戻る" onclick="history.back();">
            <input class="registerButton" type="button" value="返却画面へ" onclick="location.href='return.php?id=<?php echo $id ?>';">
        </p>
    </div>

</body>

</html>