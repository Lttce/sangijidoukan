<?php
//カッコ内のファイルを読み込む
require('../dbconnect.php');

# error_reporting(E_ALL & ~E_NOTICE); //アレ
//セッションをスタートする
session_start();

//$_POSTが空欄ではなかったら = フォームが送信されたら
if (!empty($_POST)) {
    //ログイン処理
    //ユーザIDとパスワードが空欄ではなかったら
    if ($_POST['userid'] != '' && $_POST['password'] != '') {
        $login = $db->prepare('SELECT * FROM admin WHERE userid=? AND password=?');
        $login->execute(array(
            $_POST['userid'],
            sha1($_POST['password']) //ハッシュ
        ));
        //レコードを取り出して変数（$admin）に格納する
        $admin = $login->fetch();

        //入力された内容が$adminと同じだったら
        if ($admin) {
            //ログイン成功
            //idと現在の時刻をセッションに格納する
            //index.phpに移動する
            //移動後は以降のプログラムが実行されないようにする
            $_SESSION['id'] = $admin['id'];
            $_SESSION['time'] = time();
            header('Location: index.php'); //ここをホーム画面にする 'Location: index.php'
            exit();
        } else {
            //ログイン失敗
            //$error['login']に'failed'という文字を代入する
            $error['login'] = 'failed';
        }
    } else {
        //ユーザIDかパスワードが空欄だったら
        //$error['login']に'blank'という文字を代入する
        $error['login'] = 'blank';
    }
    $userid = $_POST['userid']; //変更点42行から48行
    $password = $_POST['password'];
} else {
    $userid = ""; //エラー回避
    $password = "";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ログイン｜産技児童館</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="bonsai.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="loginBg">

    <div class="loginBox">

        <h1>産技児童館</h1>

        <div class="loginBoxInner">
            <form action="" method="post">
                <table class="loginTable">
                    <tr>
                        <th><input type="text" class="material-icons" value="account_circle" disabled></th>
                        <td><input class="loginText" type="text" name="userid" placeholder="ユーザID" value="<?php echo htmlspecialchars("$userid", ENT_QUOTES); ?>"></td>
                    </tr>

                    <tr>
                        <th><input type="text" class="material-icons" value="lock" disabled></th>
                        <td><input class="loginText" type="password" name="password" placeholder="パスワード" value="<?php echo htmlspecialchars("$password", ENT_QUOTES); ?>"></td>
                    </tr>
                </table>
                <p>
                    <input class="loginButton" type="submit" value="ログイン">
                </p>
                <!-- htmlspecialchars関数 = HTMLタグの効果を打ち消す（安全な値に加工する） -->
                <!-- $error['login']が'blank'だったら -->
                <?php if (isset($error['login']) == 'blank') : ?>
                    <p class="error">ユーザIDとパスワードを入力してください</p>
                <?php endif; ?>
                <!-- $error['login']が'failed'だったら -->
                <?php if (isset($error['login']) == 'failed') : ?>
                    <p class="error">ログインに失敗しました<br>正しく記入してください</p>
                <?php endif; ?>
            </form>
        </div>
    </div>

</body>

</html>