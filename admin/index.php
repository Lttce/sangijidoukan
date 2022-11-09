<?php require('login-check.php'); ?>

<?php
/*error_reporting(E_ALL & ~E_NOTICE); //アレ*/
if (!empty($_POST)) {
    //エラー項目の確認
    //$_POST['●●●●●']が空欄だったら
    //$error['●●●●●']に'blank'という文字を代入する
    if ($_POST['title'] == '') {
        $error['title'] = 'blank';
    }
    if ($_POST['author'] == '') {
        $error['author'] = 'blank';
    }
    if ($_POST['publisher'] == '') {
        $error['publisher'] = 'blank';
    }
    if ($_POST['issue'] == '') {
        $error['issue'] = 'blank';
    }
    if ($_POST['page'] == '') {
        $error['page'] = 'blank';
    }
    if ($_POST['age'] == '') {
        $error['age'] = 'blank';
    }
    //拡張子が「.jpg」または「.png」であるかを確認する
    //$_FILES['name属性']['内容'] = アップロードされたファイルの情報
    $fileName1 = $_FILES['cover']['name'];
    if (!empty($fileName1)) {
        //substr = 文字列から一部を切り取る（-3は後ろから3文字）
        $ext = substr($fileName1, -3);
        if ($ext != 'jpg' && $ext != 'png') {
            $error['cover'] = 'type1';
        }
    }
    //拡張子が「.pdf」であるかを確認する
    $fileName2 = $_FILES['pdf']['name'];
    if (!empty($fileName2)) {
        $ext = substr($fileName2, -3);
        if ($ext != 'pdf') {
            $error['pdf'] = 'type2';
        }
    }
    //何もエラーがなかったら
    if (empty($error)) {
        //画像をアップロードする
        //move_uploaded_file(アップロード元, アップロード先)
        //tmp_name = 一時ファイルの保存場所
        $cover = $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], '../cover/' . $cover);
        //PDFをアップロードする
        $pdf = $_FILES['pdf']['name'];
        move_uploaded_file($_FILES['pdf']['tmp_name'], '../pdf/' . $pdf);
        //セッションに各値を保存する
        $_SESSION['join'] = $_POST;
        $_SESSION['join']['cover'] = $cover;
        $_SESSION['join']['pdf'] = $pdf;
        //check.phpに移動する
        header('Location: check.php');
        exit();
    }
    $title = $_POST['title']; //変数に代入
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $issue = $_POST['issue'];
    $page = $_POST['page'];
    $age = $_POST['age'];
    $description = $_POST['description'];
} else { //空白だったら
    $title = "";  //変数に代入してエラー回避
    $author = "";
    $publisher = "";
    $issue = "";
    $page = "";
    $age = "";
    $description = "";
}

//書き直す（ページが戻った時に入力情報を保持する）
//$_REQUEST = オールマイティに使えるスーパーグローバル変数
//name属性'action'が'rewrite'だったらセッション情報を$_POSTに戻す
if (isset($_REQUEST['action']) == 'rewrite') {
    $_POST = $_SESSION['join'];
    $title = $_POST['title']; //戻したセッション情報を変数に代入
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $issue = $_POST['issue'];
    $page = $_POST['page'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $error['rewrite'] = true;
}

//DB内の投稿内容を取得する
$books = $db->query('SELECT id, title FROM books ORDER BY id DESC');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>新規登録及び登録一覧｜産技児童館</title>
    <link rel="icon" type="image/png" href="bonsai.png">
    <link rel="stylesheet" href="style.css">

    <!-- TableSorterのコード -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#lendTable").tablesorter({
                headers: {
                    3: {
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

        <div class="searchHeader">
            <div class="h2Titlee">
                <a name="bookList">
                    <h2>登録一覧</h2>
                </a>
            </div>
            <form action="searchbook.php" method="post" class="searchWindow">
                <input type="text" name="search_name" placeholder="書籍名" class="searchBox">
                <input type="submit" name="submit" value="検索" class="listButton">
            </form>
        </div>
        <table class="registerTable tablesorter" id="lendTable">
            <thead>
                <tr>
                    <th>書籍番号</th>
                    <th>書籍名</th>
                    <th style="color: #fff;"></th>
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
                            <div class="bookOperation">
                                <input class="listButton" type="button" value="詳細" onclick="location.href='detail.php?id=<?php echo $book['id']; ?>'">&nbsp;
                                <input class="listButton" type="button" value="変更" onclick="location.href='update.php?id=<?php echo $book['id']; ?>'">&nbsp;
                                <input class="listButton" type="button" value="削除" onclick="location.href='delete.php?id=<?php echo $book['id']; ?>'">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <div class="registerForm">
        <a name="newBook">
            <h2>新規登録</h2>
        </a>
        <!-- enctype="multipart/form-data" = ファイルアップロードする場合にはこの属性と属性値を必ず付ける -->
        <form action="" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>書籍名</th>
                    <td>
                        <input class="registerText" type="text" name="title" value="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>" placeholder="（例）さんぎものがたり" required>
                        <?php if (isset($error['title']) == 'blank') : ?>
                            <p class="error">書籍名を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>作者</th>
                    <td>
                        <input class="registerText" type="text" name="author" value="<?php echo htmlspecialchars($author, ENT_QUOTES); ?>" placeholder="（例）産技太郎" required>
                        <?php if (isset($error['author']) == 'blank') : ?>
                            <p class="error">作者を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>出版社</th>
                    <td>
                        <input class="registerText" type="text" name="publisher" value="<?php echo htmlspecialchars($publisher, ENT_QUOTES); ?>" placeholder="（例）産技出版" required>
                        <?php if (isset($error['publisher']) == 'blank') : ?>
                            <p class="error">出版社を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>発行日</th>
                    <td>
                        <input class="registerText" type="text" name="issue" value="<?php echo htmlspecialchars($issue, ENT_QUOTES); ?>" placeholder="（例）2019/05/01" pattern="\d\d\d\d/\d\d/\d\d" required>
                        <?php if (isset($error['issue']) == 'blank') : ?>
                            <p class="error">発行日を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>ページ数</th>
                    <td>
                        <input class="registerText" type="text" name="page" value="<?php echo htmlspecialchars($page, ENT_QUOTES); ?>" placeholder="（例）20" required>
                        <?php if (isset($error['page']) == 'blank') : ?>
                            <p class="error">ページ数を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>対象年齢</th>
                    <td>
                        <input class="registerText" type="text" name="age" value="<?php echo htmlspecialchars($age, ENT_QUOTES); ?>" placeholder="（例）4〜6歳" required>
                        <?php if (isset($error['age']) == 'blank') : ?>
                            <p class="error">対象年齢を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td><textarea class="registerArea" name="description" rows="5"><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea></td>
                </tr>
                <tr>
                    <th>表紙画像(.jpg .png)</th>
                    <td>
                        <input class="registerFile" type="file" name="cover" required>
                        <?php if (isset($error['cover']) == 'type1') : ?>
                            <p class="error">画像は「.jpg」または「.png」を指定してください</p>
                        <?php endif; ?>
                        <!-- ファイルアップロードのカラムは再現できないため警告を表示する -->
                        <?php if (!empty($error)) : ?>
                            <p class="error">恐れ入りますが、画像を改めて指定してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>書籍PDF(.pdf)</th>
                    <td>
                        <input class="registerFile" type="file" name="pdf" required>
                        <?php if (isset($error['pdf']) == 'type2') : ?>
                            <p class="error">ファイルは「.pdf」を指定してください</p>
                        <?php endif; ?>
                        <?php if (!empty($error)) : ?>
                            <p class="error">恐れ入りますが、ファイルを改めて指定してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <p>
                <input class="registerButton" type="submit" value="確認する">
            </p>
        </form>
    </div>


</body>

</html>