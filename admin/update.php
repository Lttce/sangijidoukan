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
//$_POSTが空欄ではなかったら = フォームが送信されたら
if (!empty($_POST)) {
    //エラー項目の確認
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
    $fileName1 = $_FILES['cover']['name'];
    if (!empty($fileName1)) {
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
    if (empty($error)) {
        //画像をアップロードする
        $cover = $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], '../cover/' . $cover);
        $_POST['cover'] = $cover;
        //PDFをアップロードする
        $pdf = $_FILES['pdf']['name'];
        move_uploaded_file($_FILES['pdf']['tmp_name'], '../pdf/' . $pdf);
        $_POST['pdf'] = $pdf;
        //変更処理をする
        $statement = $db->prepare('UPDATE books SET title=?, author=?, publisher=?, issue=?, page=?, age=?, description=? WHERE id=?');
        $statement->execute(array(
            $_POST['title'],
            $_POST['author'],
            $_POST['publisher'],
            $_POST['issue'],
            $_POST['page'],
            $_POST['age'],
            $_POST['description'],
            //取得した記事のidも指定する
            $_POST['id']
        ));
        //update-finish.phpに移動する
        header('Location: update-finish.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>登録変更｜産技児童館</title>
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
        <h2>登録変更</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- 変更する記事のidを指定する -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table class="">
                <tr>
                    <th>書籍名</th>
                    <td>
                        <input class="registerText" type="text" name="title" value="<?php echo $book['title']; ?>">
                        <?php if (isset($error['title']) == 'blank') : ?>
                            <p class="error">書籍名を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>作者</th>
                    <td>
                        <input class="registerText" type="text" name="author" value="<?php echo $book['author']; ?>">
                        <?php if (isset($error['author']) == 'blank') : ?>
                            <p class="error">作者を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>出版社</th>
                    <td>
                        <input class="registerText" type="text" name="publisher" value="<?php echo $book['publisher']; ?>">
                        <?php if (isset($error['publisher']) == 'blank') : ?>
                            <p class="error">出版社を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>発行日</th>
                    <td>
                        <input class="registerText" type="text" name="issue" value="<?php echo $book['issue']; ?>" pattern="\d\d\d\d/\d\d/\d\d">
                        <?php if (isset($error['issue']) == 'blank') : ?>
                            <p class="error">発行日を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>ページ数</th>
                    <td>
                        <input class="registerText" type="text" name="page" value="<?php echo $book['page']; ?>">
                        <?php if (isset($error['page']) == 'blank') : ?>
                            <p class="error">ページ数を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>対象年齢</th>
                    <td>
                        <input class="registerText" type="text" name="age" value="<?php echo $book['age']; ?>">
                        <?php if (isset($error['age']) == 'blank') : ?>
                            <p class="error">対象年齢を入力してください</p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>説明文</th>
                    <td><textarea class="registerArea" name="description" rows="5"><?php echo $book['description']; ?></textarea></td>
                </tr>

                <!--
        <tr>
          <th>表紙画像</th>
          <td>
            <input class="registerFile" type="file" name="cover" required>
            <?php if (isset($error['cover']) == 'type1') : ?>
              <p class="error">画像は「.jpg」または「.png」を指定してください</p>
              <p class="error">恐れ入りますが、画像を改めて指定してください</p>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <th>書籍PDF</th>
          <td>
            <input class="registerFile" type="file" name="pdf" required>
            <?php if (isset($error['pdf']) == 'type2') : ?>
              <p class="error">ファイルは「.pdf」を指定してください</p>
              <p class="error">恐れ入りますが、ファイルを改めて指定してください</p>
            <?php endif; ?>
          </td>
        </tr>
    -->
            </table>
            <p>
                <input class="registerButton" type="button" value="戻る" onclick="location.href='index.php'">&nbsp;
                <input class="registerButton" type="submit" value="変更する">
            </p>
        </form>
    </div>

</body>

</html>