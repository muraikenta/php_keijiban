<?php
	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP掲示板</title>
	<meta charset="UTF-8">
</head>
<body>

	<h1>掲示板</h1>



	<?php if ($_SESSION['login'] == 1): ?>
	<a href="logout.php">ログアウト</a>
		<form action="" method="POST">
			<p>名前：<br/><input type="text" name="name" value="<?php echo $_SESSION['name'] ?>"></p>
			<p>件名：<br/><input type="text" name="kenmei"></p>
			<p>本文：<br/><textarea type="text" name="content" cols="50" rows="4"></textarea></p>
			<!-- <p>削除パス：（半角英数字、４桁）<br/><input type="text" name="pass" maxlength="4"></p> -->
			<p><input type="submit" vaule="書き込む"></p><hr/>
		</form>
	<?php else: ?>
	<a href="register.php">新規ユーザー登録</a>
		<h2>ログイン</h2>
		<form action="login.php" method="POST">
			<p>ユーザー名: <input type="text" name="user_name"></p>
			<p>パスワード : <input type="password" name="password"></p>
			<p><input type="submit" value="ログイン"></p>
		</form>
	<?php endif ?>


<?php

// サニタイジングのための関数
function convString($string) {
 	if(get_magic_quotes_gpc()){
    	$string = stripslashes($string); #￥タグを表示
    }
    $string = htmlspecialchars($string,ENT_QUOTES,'UTF-8');
    $string = str_replace(array("\r\n","\n","\r"),"<br />",$string);
    return $string;
}

// バリデーション用。
$isName = !empty($_POST["name"]);
$isKenmei = isset($_POST["kenmei"]);
$isContent = !empty($_POST["content"]);
$isPass = !empty($_POST["pass"]);

if ($isName) {
	$name = convString($_POST["name"]);
}else{
	$name = "名無しさん";
}
if ($isKenmei) {
	$kenmei = convString($_POST["kenmei"]);
}else{
	$kenmei = null;
}
if ($isContent) {
	$content = convString($_POST["content"]);
}else{
	$content = null;
}
if ($isPass) {
	$pass = convString($_POST["pass"]);
}else{
	$pass = "0000";
}


// データベース接続
$dsn = "mysql:dbname=keijiban;host=localhost";
$user = "root";
$password = "root";
try {
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query("SET NAMES UTF-8");
} catch (PDOException $e) {
	var_dump($e->getMessage());
	exit;
}


if($isContent){
	// データベースへの挿入
	$stmt = $dbh->prepare('INSERT INTO keijiban2(name,kenmei,content,pass) VALUES(\''.$name.'\',\''.$kenmei.'\',\''.$content.'\',\''.$pass.'\')');
	$stmt->execute();
}

// ページの初期値は1
if(isset($_GET["page"])){
	$page = $_GET["page"];
}else{
	$page = 1;
}

// データベースからデータを取り出す
$stmt = $dbh->query("SELECT * FROM keijiban2");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// データベースとの接続を切る
$dbh = null;

// ページャ処理
$kensu = count($result);
$maxPage = ceil($kensu/5);
$start = $kensu - $page*5+4;
$hyouji=max($start-5,-1);
for ($i = $start; $i>$hyouji  ; $i--) {
	echo "No.{$result[$i]['id']}　";
	echo "名前：{$result[$i]['name']}　";
	echo "件名：{$result[$i]['kenmei']}";
	//echo "<a style='float:right' href='delete.php?id={$result[$i]['id']}'><input type='button' value='✕'></a><br/>";
	echo "{$result[$i]['content']}<br/><hr/>";
}

echo "<ul>";

$prevPage = $page-1;
$nextPage = $page+1;
echo "<li><a href=\"keijiban.php?page=1\">最新の投稿</a></li>";
if($page == 1){
	echo "<li>前のページへ</li>";
	echo "<li><a href=\"keijiban.php?page=$nextPage\">次のページヘ</a></li>";
}
if($page>1 && $page<$maxPage){
	echo "<li><a href=\"keijiban.php?page=$prevPage\">前のページヘ</a></li>";
	echo "<li><a href=\"keijiban.php?page=$nextPage\">次のページヘ</a></li>";
}
if($page==$maxPage){
	echo "<li><a href=\"keijiban.php?page=$prevPage\">前のページヘ</a></li>";
	echo "<li>次のページヘ</li>";
}
echo "<li><a href=\"keijiban.php?page=$maxPage\">最初の投稿</a></li>";

?>
	</ul>
</body>

</html>
