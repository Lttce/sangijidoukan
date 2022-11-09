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
<?php
      header("Location: ../pdf/$book[pdf]");
?>
