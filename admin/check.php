<?php
session_start();
require('../dbconnect.php');

//$_SESSION['join']に何も存在していなかったら（入力画面を経ずにアクセスしてきたら）
if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
}

//$_POSTが空欄ではなかったら = フォームが送信されたら
if (!empty($_POST)) {
    //登録処理をする
    $statement = $db->prepare('INSERT INTO books SET title=?, author=?, publisher=?, issue=?, page=?, age=?, description=?, cover=?, pdf=?');
    $statement->execute(array(
        htmlspecialchars($_SESSION['join']['title'], ENT_QUOTES),
        htmlspecialchars($_SESSION['join']['author'], ENT_QUOTES),
        htmlspecialchars($_SESSION['join']['publisher'], ENT_QUOTES),
        htmlspecialchars($_SESSION['join']['issue'], ENT_QUOTES),
        htmlspecialchars($_SESSION['join']['page'], ENT_QUOTES),
        htmlspecialchars($_SESSION['join']['age'], ENT_QUOTES),
        htmlspecialchars($_SESSION['join']['description'], ENT_QUOTES),
        $_SESSION['join']['cover'],
        $_SESSION['join']['pdf']
    ));
    //登録処理が終わったため入力情報を削除する
    unset($_SESSION['join']);
    //finish.phpに移動する
    header('Location: finish.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>登録確認｜産技児童館</title>
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
        <h2>登録確認</h2>
        <form action="" method="post">
            <input type="hidden" name="action" value="submit">
            <table class="detailTable">
                <tr>
                    <th>書籍名</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['title'], ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <th>作者</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['author'], ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <th>出版社</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['publisher'], ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <th>発行日</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['issue'], ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <th>ページ数</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['page'], ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <th>対象年齢</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['age'], ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td><?php echo nl2br(htmlspecialchars($_SESSION['join']['description'], ENT_QUOTES)); ?></td>
                </tr>
                <tr>
                    <th>表紙画像</th>
                    <td><img src="../cover/<?php echo htmlspecialchars($_SESSION['join']['cover'], ENT_QUOTES); ?>" witdh="auto" height="200" alt=""></td>
                </tr>
                <tr>
                    <th>書籍PDF</th>
                    <td><?php echo htmlspecialchars($_SESSION['join']['pdf'], ENT_QUOTES); ?></td>
                </tr>
            </table>
            <p>
                <input class="registerButton" type="button" value="書き直す" onclick="location.href='index.php?action=rewrite'">&nbsp;
                <input class="registerButton" type="submit" value="登録する">
            </p>
        </form>
    </div>

</body>

</html>