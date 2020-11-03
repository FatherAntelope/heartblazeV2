<?php
//проверка доступа к личному кабинету и существование учетной записи, если доступ к нему есть
function getDataIsAuthAndEmptyPerson($isRole) {
    if($_COOKIE['person_role'] === $isRole) {
        require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
        $person = R::load('person', $_COOKIE['person_ID']);
        if(count($person) <= 1) {
            setcookie('person_role',   '', time() - (60*60*24*30), "/");
            setcookie('person_ID',   '', time() - (60*60*24*30), "/");
            header("Location: /");
        }
        return $person;
    } else {
        die(header("HTTP/1.1 401 Unauthorized "));
    }
}
?>