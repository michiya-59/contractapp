<?php 

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login']) === false)
{
  print 'ログインされていません'.'<br>';
  print '<a href="../contract_staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
}
else
{
  print $_SESSION['staff_name'];
  print 'さんログイン中'.'<br>'.'<br>';
}

try
{
$staff_code = $_GET['staffcode'];

$dsn = 'mysql:dbname=heroku_c23ca7e7a15de58;host=us-cdbr-east-03.cleardb.com;charset=utf8';
$user = 'bbbde1a622f568';
$password = 'a363e2dc';
$dbh = new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT name FROM staff WHERE code = ?;';
$stmt = $dbh->prepare($sql);
$data[] = $staff_code;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$staff_name = $rec['name'];

$dbh = null;
}

catch(Exception $e)
{
  print 'ただいま障害により大変ご迷惑お掛けしております。';
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  スタッフ修正
  <br>
  <br>
  スタッフコード
  <?php print $staff_code; ?>
  <br>
  <br>
  <form action="staff_edit_check.php" method="post">
  <input type="hidden" name="code" value="<?php print $staff_code; ?>">
  スタッフ名<br>
  <input type="text" name="name" value="<?php print $staff_name; ?>" style="width:200px"><br>
  パスワードを入力してください<br>
  <input type="password" name="pass" stayle="width100px">
  <br>
  パスワードをもう一度入力してください<br>
  <input type="password" name="pass2" style="width:100px"><br>
  <br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
  </form>

</body>
</html>