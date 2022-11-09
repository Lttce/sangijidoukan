<?php
require('login-check.php');

try {
    //DBに接続
    //SQL文を実行して、結果を$stmtに代入する。
    $stmt = $db->prepare(" SELECT id, title FROM books WHERE  title LIKE ?");

    //実行する
    $stmt->execute([
        "%{$_POST["search_name"]}%"
    ]);
} catch (PDOException $e) {
    echo "失敗:" . $e->getMessage() . "\n";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>一覧画面｜産技児童館</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">

    <!-- TableSorterのコード -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#lendTable").tablesorter({
                headers: {
                    4: {
                        sorter: false
                    }
                }
            });
        });
    </script>
    <!-- ここまで -->

</head>

<body class="adminBg">
    <header>
        <div class="headerInner">
            <div class="headerLeft">
                <a name="top">産技児童館</a>
            </div>
            <div class="headerCenter">
                <a href="index.php">書籍登録</a>
                <a href="index.php#bookList">書籍一覧</a>
                <a href="lend.php">貸出登録</a>
                <a href="list.php">貸出一覧</a>
            </div>
            <div class="headerRight">
                <a href="logout.php">ログアウト</a>
            </div>
        </div>
    </header>
    <div class="registerList">
        <h2>検索結果</h2>
        <table class="registerTable tablesorter" id="lendTable">
            <thead>
                <tr>
                    <th>貸出ID</th>
                    <th>書籍名</th>
                    <th style="color: #fff;"></th>
                </tr>
            </thead>
            <tbody>
                <!-- ここでPHPのforeachを使って結果をループさせる -->
                <?php foreach ($stmt as $row) : ?>
                    <tr>
                        <td>
                            <div class="bookId"><?php echo $row[0] ?></div>
                        </td>
                        <td>
                            <div class="bookTitle"><?php echo $row[1] ?></div>
                        </td>
                        <td>
                            <div class="bookOperation">
                                <input class="listButton" type="button" value="詳細" onclick="location.href='detail.php?id=<?php echo $row[0]; ?>'">&nbsp;
                                <input class="listButton" type="button" value="変更" onclick="location.href='update.php?id=<?php echo $row[0]; ?>'">&nbsp;
                                <input class="listButton" type="button" value="削除" onclick="location.href='delete.php?id=<?php echo $row[0]; ?>'">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p align="center">
            <input type="button" value="戻る" class="registerButton" onclick="history.back();">
    </div>
    </p>
</body>

</html>