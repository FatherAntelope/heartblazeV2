<?php
//mail('gorbunov.vladlen2014@gmail.com', 'My Subject', "http://heartblaze.ru/?email_key=fsddfhfdjjfd");
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
R::freeze(true);
?>
