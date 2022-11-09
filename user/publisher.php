<?php
  /*error_reporting(E_ALL & ~E_NOTICE); //アレ*/
  //DB内の投稿内容を取得する
  require('../dbconnect.php');
  $books = $db->query('SELECT id, title, cover, age, pdf, page, publisher,issue FROM books ORDER BY publisher ASC');
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <title>いちらんがめん｜さんぎじどうかん</title>
    <link rel="stylesheet" href="style.css">
<body>
<div class="registerList">
  <h2 span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)";>いちらんがめん
    <select name="select" style="border-radius:4px;background-color: #ffffcf;width: 200px;height: 60px;font-size:30px;" onChange="location.href=value;">
      <option value="#">はっこうび</option>
      <option value="index.php">ねんれい</option>
      <option value="page.php">ページすう</option>
    </select>
  </h2>
  <font size=6>
  <ul>
    <?php foreach($books as $book): ?>
    <li>
      <div class="bookTitle">
        <dt><span style="font-size:45px;font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)";>
          <?php echo htmlspecialchars($book['title'],ENT_QUOTES); ?>
        </dt>
          <dd><span style="font-family:HGP創英角ﾎﾟｯﾌﾟ体;filter:shadow(color=magenta,direction=100)";>
            <?php
              $issue = $book['issue'];
              echo htmlspecialchars($issue,ENT_QUOTES); ?>
            </dd></div>
      <div class="cover">
        <a href='jump.php?id=<?php echo $book['id']; ?>'><img src="../cover/<?php echo $book['cover']; ?>" width="auto" height="400" alt=""></a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>

</body>

</html>
