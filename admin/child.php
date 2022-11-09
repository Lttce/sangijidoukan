<?php
require('login-check.php');


$id = $_REQUEST['id'];

# 児童情報取得SQL
$child_sql = 'SELECT name, address, birthday
              FROM lending
              WHERE id = ?';
$sth = $db->prepare($child_sql);
$sth->execute([$id]);
$detail_child = $sth->fetch();
# print_r($detail_child);
if(empty($detail_child)){
    header('Location: list.php');
    exit();
}


# 児童貸出書籍取得SQL
$child_books_sql = 'SELECT * FROM lending WHERE name = ? AND address = ? AND birthday = ?';

$sth = $db->prepare($child_books_sql);
$sth->execute([
    $detail_child['name'],
    $detail_child['address'],
    $detail_child['birthday']
]);
$rows = $sth->fetchall();


# 書籍を一括で返却する処理
# submitが押されたら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # 削除する
    $del_sql = 'DELETE FROM lending WHERE name = ? AND address = ? AND birthday = ?';
    $sth = $db->prepare($del_sql);
    $sth->execute([
        $detail_child['name'],
        $detail_child['address'],
        $detail_child['birthday']
    ]);
    # 貸出情報削除SQL
    header('Location: return-finish.php');
    exit();
}


?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>産技児童館｜児童情報</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">
    <script>
        ask = () => {
            return confirm('本当に全て返却しますか？');
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
        <h2>貸出情報</h2>
        <form action="" method="post" onsubmit="return ask();">
            <div class="childCont">

                <div class="cont1">
                    <h3>児童情報</h3>
                    <table class="childDetail">
                        <tr>
                            <th>児童名</th>
                            <td class="name"><?php echo $rows[0]['name'] ?></td>
                        </tr>
                        <tr>
                            <th>生年月日</th>
                            <td class="birthday"><?php echo $rows[0]['birthday'] ?></td>
                        </tr>
                        <tr>
                            <th>住所</th>
                            <td class="address"><?php echo $rows[0]['address'] ?></td>
                        </tr>
                    </table>

                    <h3>日付情報</h3>
                    <table class="dateDetail">
                        <tr>
                            <th>貸出日</th>
                            <td class="date"><?php echo $rows[0]['date'] ?></td>
                        </tr>
                        <tr>
                            <th>返却日</th>
                            <td class="date"><?php echo $rows[0]['returndate'] ?></td>
                        </tr>
                    </table>
                </div>

                <div class="cont2">
                    <h3>書籍情報</h3>
                    <table class="bookDetail">
                        <tr>
                            <th>貸出ID</th>
                            <th>書籍名</th>
                            <th></th>
                        </tr>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td class="id"><?php echo $row['id'] ?></td>
                                <td class="title"><?php echo $row['title'] ?></td>
                                <td><input type="button" value="返却" class="listButton" onclick="location.href='return.php?id=<?php echo $row['id'] ?>'"></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <p>
                <input type="button" value="戻る" class="registerButton" onclick="history.back();">
                <input type="submit" value="全て返却" class="registerButton">
            </p>
        </form>
    </div>

</body>

</html>