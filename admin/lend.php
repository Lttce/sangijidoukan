<?php require('login-check.php');

# 貸出登録処理
# submitが押された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # レコードが存在するか確認
    $sth = $db->prepare('SELECT name, COUNT(name) as "貸出数" FROM lending WHERE name = ? AND address = ? AND birthday= ?');
    $sth->execute([
        $_POST['name'],
        $_POST['address'],
        $_POST['birthdate'],
    ]);
    $row = $sth->fetch();
    print_r($row);
    $lend_count = $row['貸出数'];

    # 本を1冊でも借りていたら
    # 借りることは出来ない
    if ($lend_count > 0) {
        # 
        $_SESSION['limit'] = '借りている本を返却してください';

        # このページを再読み込みする
        header('Location: lend.php');
        exit();

        # 本を借りていなかったら
    } else {

        # タイトルのリスト
        $titles = [
            htmlspecialchars($_POST['title0'], ENT_QUOTES),
            htmlspecialchars($_POST['title1'], ENT_QUOTES),
            htmlspecialchars($_POST['title2'], ENT_QUOTES),
            htmlspecialchars($_POST['title3'], ENT_QUOTES),
            htmlspecialchars($_POST['title4'], ENT_QUOTES),
        ];

        # 貸出情報をDBに書き込む
        foreach ($titles as $title) {
            # タイトルが書き込まれていたら
            if ($title != null) {
                $sth = $db->prepare('INSERT INTO lending(date, returndate, title, name, address, birthday) VALUE(?, ?, ?, ?, ?, ?)');
                $sth->execute([
                    # inputのname属性
                    htmlspecialchars($_POST['date'], ENT_QUOTES),
                    htmlspecialchars($_POST['returndate'], ENT_QUOTES),
                    $title,
                    htmlspecialchars($_POST['name'], ENT_QUOTES),
                    htmlspecialchars($_POST['address'], ENT_QUOTES),
                    htmlspecialchars($_POST['birthdate'], ENT_QUOTES)
                ]);
            }
        }

        # 貸出完了画面に飛ぶ
        header('Location: lend-finish.php');
        exit();
    }
}

# 
date_default_timezone_set('Asia/Tokyo');

# 今日の日付を貸出日に入れる
$today = date('Y/m/d');

# 一週間後の日付を返却日に入れる
$one_week_later = date('Y/m/d', strtotime('+1 week', time()));

?>
<?php
$url = 'http://s-proj.com/utils/getBusinessDay.php?kind=prev&date_format=yyyy/mm/dd&date=';
$url .= $one_week_later;
$one_week_later = file_get_contents($url);
$holiday = "返却予定日が祝日です。予定日を入力してください。";
$alert = "<script type='text/javascript'>alert('" . $holiday . "');</script>";
if ($one_week_later < date('Y/m/d', strtotime('+1 week', time()))) {
    echo $alert;
    $one_week_later = "";
};
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>貸出画面｜産技児童館</title>
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



    <form action="" method="post" class="registerForm">
        <h2>貸出登録</h2>
        <div class="container">

            <div class="cont1">
                <h3>書籍情報</h3>
                <table class="lendRegister">
                    <tr>
                        <th>書籍名</th>
                        <td><input type="text" required placeholder="（例）それいけアンパンマン" name="title0" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>書籍名</th>
                        <td><input type="text" placeholder="（例）それいけアンパンマン" name="title1" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>書籍名</th>
                        <td><input type="text" placeholder="（例）それいけアンパンマン" name="title2" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>書籍名</th>
                        <td><input type="text" placeholder="（例）それいけアンパンマン" name="title3" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>書籍名</th>
                        <td><input type="text" placeholder="（例）それいけアンパンマン" name="title4" class="registerText"></td>
                    </tr>
                </table>
            </div>

            <div class="cont2">
                <h3>予定</h3>
                <table class="lendRegister">
                    <tr>
                        <th>貸出日</th>
                        <td><input type="text" required value="<?php echo $today ?>" pattern="\d\d\d\d/\d\d/\d\d" placeholder="（例）2000/01/01" name="date" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>返却日</th>
                        <td><input type="text" required value="<?php echo $one_week_later ?>" pattern="\d\d\d\d/\d\d/\d\d" placeholder="（例）2000/01/07" name="returndate" class="registerText"></td>
                    </tr>
                </table>

                <h3>児童情報</h3>
                <table class="lendRegister">
                    <tr>
                        <th>借りた人</th>
                        <td><input type="text" required placeholder="（例）桟木太郎" name="name" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td><input type="text" required placeholder="（例）静岡県静岡市葵区追手町404-0" name="address" class="registerText"></td>
                    </tr>
                    <tr>
                        <th>生年月日</th>
                        <td><input type="text" required placeholder="（例）1997/06/02" pattern="\d\d\d\d/\d\d/\d\d" name="birthdate" class="registerText"></td>
                    </tr>
                </table>
            </div>

        </div>
        <p>
            <input type="button" value="戻る" class="registerButton" onclick="location.href='list.php'">
            <input type="submit" value="貸し出す" class="registerButton" name="lend">
        </p>
        <p class="error">
            <?php
            if (isset($_SESSION['limit'])) {
                # 貸出上限メッセージ
                echo $_SESSION['limit'];

                # リロードした際にエラーを消す処理
                $_SESSION['limit'] = null;
            }
            ?>
        </p>
    </form>


</body>

</html>