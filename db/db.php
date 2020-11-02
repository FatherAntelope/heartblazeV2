<?php
require $_SERVER['DOCUMENT_ROOT']."/frameworks/rb.php";
$username = 'root';
$password = 'root';
$dbname = 'heartblaze';
$hostname = 'localhost';
R::setup( "mysql:host={$hostname};dbname={$dbname}", $username, $password);
if ( !R::testConnection() )
{
    exit ('Нет подключения к базе данных!');
}
?>
