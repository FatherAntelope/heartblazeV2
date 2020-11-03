<?php
//проверка доступа к личному кабинету и существование учетной записи, если доступ к нему есть
function getDataIsAuthAndEmptyPerson($isRole) {
    if($_COOKIE['role'] === $isRole) {
        require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
        $person = R::load('person', $_COOKIE['personID']);
        if(count($person) <= 1) {
            setcookie('role',   '', time() - (60*60*24*30), "/");
            setcookie('personID',   '', time() - (60*60*24*30), "/");
            header("Location: /");
        }
        return $person;
    } else {
        die(header("HTTP/1.1 401 Unauthorized "));
    }
}
?>