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
<div class="registerList">
  <div class="registerForm">
    <h2 span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100);">しょうさい</h2>
    <dl>
      <div class="cont">
        <div class="detail">
          <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)";>
            なまえ
          </dt>
          <dd><?php echo $book['title']; ?></dd>
          <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
            ページ
          </dt>
          <dd><?php echo $book['page']; ?></dd>
          <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
            たいしょうねんれい
          </dt>
          <dd>
            <?php
            $age = $book['age'];
            $age = str_replace("歳", "さい", $age);
            echo htmlspecialchars($age, ENT_QUOTES); ?>
          </dd>
          <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
            せつめい
          </dt>
          <dd><?php echo nl2br($book['description']); ?></dd>
          <details>
            <summary span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
              さくしゃ・しゅっぱんしゃ・はっこうび
            </summary>
            <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
              さくしゃ
            </dt>
            <dd><?php echo $book['author']; ?></dd>
            <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
              しゅっぱんしゃ
            </dt>
            <dd><?php echo $book['publisher']; ?></dd>
            <dt span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)" ;>
              はっこうび
            </dt>
            <dd><?php echo $book['issue']; ?></dd>
          </details>
        </div>
        <div class="cover">
          <dd>
            <img src="../cover/<?php echo $book['cover']; ?>" width="auto" height="400" alt="">
          </dd>
          <div class="bookOperation">
            <dd><input class="registerButton" type="button" style="width:280px;height:80px;margin:0 0 0 10px;" value="よむ" onclick="location.href='read.php?id=<?php echo $book['id']; ?>'">
            </dd>
            <dd><input class="registerButton" type="button" style="width:280px;height:80px;margin:0 0 0 10px;" value="もどる" onclick="location.href='index.php'">
            </dd>
          </div>
        </div>
    </dl>
  </div>
</div>
</body>

</html>