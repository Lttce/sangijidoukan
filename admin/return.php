<?php
require('login-check.php');

# 貸出番号に対応する情報をDBから持ってくる
if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $books = $db->prepare('SELECT * FROM lending WHERE id=?');
    $books->execute([
        $id
    ]);
    $book = $books->fetch();

    # クエリ結果を見る
    # print_r($book);
}
if(empty($book)){
    header('Location: list.php');
    exit();
}

# 返却該当データをDBから削除する
# submitボタンが押されたら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # 貸出IDに対応する情報をDBから削除する
    $sth = $db->prepare('DELETE FROM lending WHERE id=?');
    $sth->execute([
        $_REQUEST['id']
    ]);

    # 返却完了画面へ飛ぶ
    header('Location: return-finish.php');
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>返却画面｜産技児童館</title>
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
        <h2>返却確認</h2>
        <p>以下の本を返却しますか</p>
        <form action="" method="post">
            <table class="detailTable">
                <tr>
                    <th>貸出番号</th>
                    <td><?php echo $book['id'] ?></td>
                </tr>
                <tr>
                    <th>書籍名</th>
                    <td><?php echo $book['title'] ?></td>
                </tr>
                <tr>
                    <th>貸出日</th>
                    <td><?php echo $book['date'] ?></td>
                </tr>
                <tr>
                    <th>返却日</th>
                    <td><?php echo $book['returndate'] ?></td>
                </tr>
                <tr>
                    <th>児童名</th>
                    <td><?php echo $book['name'] ?></td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td><?php echo $book['address'] ?></td>
                </tr>
                <tr>
                    <th>生年月日</th>
                    <td><?php echo $book['birthday'] ?></td>
                </tr>
            </table>
            <p>
            <div class="returnButton">
                <input type="button" value="戻る" class="registerButton" onclick="history.back();">
                <input type="submit" value="返却する" class="registerButton">
            </div>
            </p>
        </form>
    </div>
</body>

</html>