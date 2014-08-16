<?php
session_start();
if(isset($_SESSION["id"])){
	$id=$_SESSION["id"];
}else{
	$id=null;
}

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