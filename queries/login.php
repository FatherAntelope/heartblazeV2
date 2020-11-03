<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$person = R::findOne('person', ' login = ? ', [ $_POST['login'] ]);

if($person && password_verify($_POST['password'], $person->password)) {
    setcookie('personID', $person->id, time()+(60*60*24*30), "/");
    setcookie('role', $person->role, time()+(60*60*24*30), "/");
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}
?>