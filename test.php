<pre>
<?php include "./src/libs/load.php";
print_r($_POST);
print_r($_FILES);
print_r($_SESSION);

$db_username = get_config('database.servername');

 $r=get_config('database.username');
$u=get_config('database.dbname');
echo $db_username,$r,$u; 

?>
</pre>

