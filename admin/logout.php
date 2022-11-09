<?php
session_start();

//セッション情報を削除する
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();

//Cookie情報を削除する
//Cookieの記録を空欄にする
//時間を60分（3600秒）前に戻す（ログインの有効時間を60分としているため）
setcookie('userid', '', time() - 3600);
setcookie('password', '', time() - 3600);
//login.phpに移動する
header('Location: login.php');
exit();

?>