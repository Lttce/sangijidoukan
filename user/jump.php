<?php
//どのidの記事を取得するか
//idが存在してそれが数字だったら
require('../dbconnect.php');
if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $books = $db->prepare('SELECT * FROM books WHERE id=?');
  $books->execute(array($id));
  $book = $books->fetch();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>くわしいがめん｜さんぎじどうかん</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="registerList">
  <div class="registerForm">
    <h2 span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)";>どちらかえらんでね</h2>
    <dl>
        <div class="cover">
          <dd><a href="../pdf/<?php echo $book['pdf']; ?>"><img src="../cover/<?php echo $book['cover']; ?>" width="auto" height="400" alt=""></a></dd>
            <div class="bookOperation">
              <dd><input class="registerButton" type="button" style="width:280px;height:80px;" value="よむ" onclick="location.href='read.php?id=<?php echo $book['id']; ?>'"></dd>
              <dd><input class="registerButton" type="button" style="width:280px;height:80px;" value="くわしく" onclick="location.href='detail.php?id=<?php echo $book['id']; ?>'"></dd>
              <dd><input class="registerButton" type="button" style="width:280px;height:80px;" value="もどる" onclick="location.href='index.php'"></dd>
          </div>
       </div>
       </div>
    </dl>
</body>

</html>
