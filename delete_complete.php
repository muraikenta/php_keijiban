<?php
session_start();
if(isset($_SESSION["id"])){
	$id=$_SESSION["id"];
}else{
	$id=null;
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

if ($id!=null) {
	$stmt = $dbh->prepare("delete from keijiban where id = $id");
	$stmt->execute();
}
$dbh=null;
?>
<html>
<head>
	<title>PHP掲示板</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<h1>削除が完了しました。</h1>
<a href="keijiban.php">戻る<a>
</body>