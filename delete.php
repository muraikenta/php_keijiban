<?php
session_start();

function convString($string) {
 	if(get_magic_quotes_gpc()){
    	$string = stripslashes($string); #￥タグを表示
    }
    $string = htmlspecialchars($string,ENT_QUOTES,'utf-8');
    $string = str_replace(array("\r\n","\n","\r"),"<br />",$string);
    return $string;
}

if(isset($_GET["id"])){
	$id=$_GET["id"];
}else{
	$id=null;
}
if(isset($_POST["pass"])){
	$pass=convString($_POST["pass"]);
}else{
	$pass="";
}

// データベース接続
$dsn = "mysql:dbname=keijiban;host=138.91.17.26";
$user = "b23176e08da199";
$password = "18bf0b2b";
try {
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query("SET NAMES UTF-8");
} catch (PDOException $e) {
	var_dump($e->getMessage());
	exit;
}

if(isset($_GET['id'])){
	$stmt=$dbh->query("select pass from keijiban where id = $id");
	$truepass = $stmt->fetch(PDO::FETCH_ASSOC);
	if($pass==$truepass['pass']){
		$_SESSION["id"]=$id;
		header("Location:delete_complete.php");
		exit();
	}
}
$dbh = null;
?>
<html>
<head>
	<title>PHP掲示板</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	削除するためにはパスワードを入力してください。<br/><br/>
	パスワード:
	<form method="post" action="">
		<input type="password" name="pass" maxlength="4">
		<input type="submit" value="送信">
	</form>
	<a href="keijiban.php">戻る</a>

<?php
if (!empty($_POST["pass"])) {
	echo "パスワードが間違っています。";
}
?>
</body>