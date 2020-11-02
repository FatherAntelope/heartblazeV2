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

setcookie('userInfo', $user, time() + (86400 * 30), "/");
setcookie('role', $user->role, time() + (86400 * 30), "/");

if ($user->role == 0) {
	header('Location: /student/lk.php');
} else {
	if ($user -> role == 1) {
		header('Location: /professor/lk.php');
	} else {
		header('Location: /administrator/lk.php');
	}
}

?>