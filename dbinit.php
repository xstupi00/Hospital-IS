<?
$db_user = 'xzubri00';
$db_pswd = 'aka4uken';
$db_host = 'localhost';
$db_sock = '/var/run/mysql/mysql.sock';
$db_name = 'xzubri00';


$dsn = "mysql:host=$db_host;unix_socket=$db_sock;dbname=$db_name";
try {
	$dbconn = new PDO($dsn, $db_user, $db_pswd);
	$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	print "Connection error! : " . $e->getMessage() . "<br/>";
	die();
} 
?>
