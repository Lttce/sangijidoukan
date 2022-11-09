<?php require('login-check.php'); ?>

<?php
if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $books = $db->prepare('SELECT * FROM books WHERE id=?');
    $books->execute(array($id));
    $book = $books->fetch();
}

if(empty($book)){
    header('Location: index.php');
    exit();
}
?>

<?php
//削除するボタンが押されたら
if (isset($_POST['delete'])) {
    //削除処理をする
    $statement = $db->prepare('DELETE FROM books WHERE id=?');
    $statement->execute(array($id));
    //delete-finish.phpに移動する
    header('Location: delete-finish.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>登録削除｜産技児童館</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">
    <script>
        ask = () => {
            return confirm('本当に書籍を削除しますか？\n元には戻せません。');
        }
    </script>
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
        <h2>登録削除</h2>
        <form action="" method="post" onsubmit="return ask();">
            <table class="detailTable">
                <tr>
                    <th>書籍名</th>
                    <td><?php echo $book['title']; ?></td>

                </tr>
                <tr>
                    <th>作者</th>
                    <td><?php echo $book['author']; ?></td>
                </tr>
                <tr>
                    <th>出版社</th>
                    <td><?php echo $book['publisher']; ?></td>
                </tr>
                <tr>
                    <th>発行日</th>
                    <td><?php echo $book['issue']; ?></td>
                </tr>
                <tr>
                    <th>ページ数</th>
                    <td><?php echo $book['page']; ?></td>
                </tr>
                <tr>
                    <th>対象年齢</th>
                    <td><?php echo $book['age']; ?></td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td><?php echo nl2br($book['description']); ?></td>
                </tr>
                <tr>
                    <th>表紙画像</th>
                    <td><img src="../cover/<?php echo $book['cover']; ?>" withh="auto" height="200" alt=""></td>
                </tr>
                <tr>
                    <th>書籍PDF</th>
                    <td><?php echo $book['pdf']; ?></td>
                </tr>
            </table>
            <p>
                <input class="registerButton" type="button" value="戻る" onclick="location.href='index.php'">&nbsp;
                <input class="registerButton" type="submit" value="削除する" name="delete">
            </p>
        </form>
    </div>

</body>

</html>