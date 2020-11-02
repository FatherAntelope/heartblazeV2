<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
R::freeze(true);

$user = R::findOne('person', ' login = ? ', [ $_POST['login'] ]);

if ($user == NULL) {
	die(header("HTTP/1.0 400 Bad Request"));
}

if (!password_verify($_POST['password'], $user->password)) {
	die(header("HTTP/1.0 400 Bad Request"));
}


setcookie('isLogged', true, time() + (86400 * 30), "/"); // 86400 = 1 day
setcookie('userInfo', $user, time() + (86400 * 30), "/");


?>