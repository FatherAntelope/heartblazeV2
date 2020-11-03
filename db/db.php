<?php
mail('gorbunov.vladlen2014@gmail.com', 'My Subject', "http://heartblaze.ru/?email_key=fsddfhfdjjfd");
require $_SERVER['DOCUMENT_ROOT']."/frameworks/rb.php";
$username = 'root';
$password = 'admin';
$dbname = 'heartblaze';
$hostname = '192.168.0.103';
R::setup( "mysql:host={$hostname};dbname={$dbname}", $username, $password);
if ( !R::testConnection() )
{
    exit ('Нет подключения к базе данных!');
}
R::freeze(true);
?>
