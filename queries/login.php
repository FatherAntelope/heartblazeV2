<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
R::freeze(true);

$user = R::findOne('person', ' login = ? ', [ $_POST['login'] ]);

<<<<<<< HEAD
if ($user == NULL) {
	die(header("HTTP/1.0 400 Bad Request"));
}

if (!password_verify($_POST['password'], $user->password)) {
	die(header("HTTP/1.0 400 Bad Request"));
}

setcookie('userInfo', $user, time() + (86400 * 30), "/");
setcookie('role', $user->role, time() + (86400 * 30), "/");



=======
if($user && password_verify($_POST['password'], $user->password)) {
    setcookie('userInfo', $user, time() + (86400 * 30), "/");
    setcookie('role', $user->role, time() + (86400 * 30), "/");
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}
>>>>>>> 61d637fcb0348b1c9cb53477ee56551a53857f5e
?>