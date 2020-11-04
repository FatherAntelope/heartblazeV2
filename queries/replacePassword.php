<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
$person = R::load('person', $_POST['person_id']);
if(password_verify($_POST['person_old_password'], $person->password)
    && (strcmp($_POST['person_new_password'], $_POST['person_repeat_password'])  == 0)) {
    $person->password = password_hash($_POST['person_new_password'], PASSWORD_DEFAULT);
    R::store($person);
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}
