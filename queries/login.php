<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$user = R::findOne('person', ' login = ? ', [ $_POST['login'] ]);

if($user && password_verify($_POST['password'], $user->password)) {
    setcookie('userID', $user->id, time()+(60*60*24*30), "/");
    setcookie('role', $user->role, time()+(60*60*24*30), "/");
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}
?>