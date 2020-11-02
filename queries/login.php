<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
R::freeze(true);

$user = R::findOne('person', ' login = ? ', [ $_POST['login'] ]);

if($user && password_verify($_POST['password'], $user->password)) {
    setcookie('userInfo', $user, time() + (86400 * 30), "/");
    setcookie('role', $user->role, time() + (86400 * 30), "/");
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}
?>