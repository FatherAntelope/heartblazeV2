<?php

require $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
R::freeze(true);

if (R::count('person', 'login = ? OR email = ?', [$_POST['user_login'], $_POST['user_email']]) == 0) {

    $user = R::dispense('person');
    $user->name = $_POST['user_first_name'];
    $user->surname = $_POST['user_last_name'];
    $user->patronymic = $_POST['user_patronymic'];
    $user->email = $_POST['user_email'];

    //password_hash($_POST['UserPassword'], PASSWORD_DEFAULT);

    $user->password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
    $user->login = $_POST['user_login'];
    $user->role = $_POST['user_role'];

    R::store($user);

} else {
    die(header("HTTP/1.0 400 Bad Request"));
}

?>
