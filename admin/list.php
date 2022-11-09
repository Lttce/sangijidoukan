<?php
require('login-check.php');

//DB内の投稿内容を取得する
$books = $db->query('SELECT id, title, name, returndate FROM lending ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>一覧画面｜産技児童館</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">
    <style>

    </style>

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
        <h2>貸出一覧

            <div class="searchHeader">
                <form action="search.php" method="post" class="searchWindow">
                    <input type="text" name="search_name" placeholder="書籍名" class="searchBox">
                    <input type="submit" name="submit" value="検索" class="listButton">
                </form>
            </div>
        </h2>

        <table class="registerTable tablesorter" id="lendTable">
            <thead>
                <tr>
                    <th>貸出ID</th>
                    <th>書籍名</th>
                    <th>児童名</th>
                    <th>返却日</th>
                    <th style="color: #fff"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book) : ?>
                    <tr>
                        <td>
                            <div class="bookId"><?php echo htmlspecialchars($book['id'], ENT_QUOTES); ?></div>
                        </td>
                        <td>
                            <div class="bookTitle"><?php echo htmlspecialchars($book['title'], ENT_QUOTES); ?></div>
                        </td>
                        <td>
                            <div class="childName"><a class="childLink" href="child.php?id=<?php echo $book['id']; ?>"><?php echo htmlspecialchars($book['name'], ENT_QUOTES); ?></a></div>
                        </td>
                        <td>
                            <div class="returnDate"><?php echo htmlspecialchars($book['returndate'], ENT_QUOTES); ?></div>
                        </td>
                        <td>
                            <div class="bookOperation">
                                <input class="listButton" type="button" value="詳細" onclick="location.href='lend-detail.php?id=<?php echo $book['id']; ?>'">&nbsp;
                                <input class="listButton" type="button" value="返却" onclick="location.href='return.php?id=<?php echo $book['id']; ?>'">&nbsp;
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>