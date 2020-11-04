<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";


if (R::count('person', 'login = ? OR email = ?', [$_POST['person_login'], $_POST['person_email']]) == 0) {

    $person = R::dispense('person');
    $person->name = $_POST['person_first_name'];
    $person->surname = $_POST['person_last_name'];
    $person->patronymic = $_POST['person_patronymic'];
    $person->email = $_POST['person_email'];
    $person->password = password_hash($_POST['person_password'], PASSWORD_DEFAULT);
    $person->login = $_POST['person_login'];
    $person->role = $_POST['person_role'];
    R::store($person);

    if($person->role == 0) {
        $student = R::dispense('student');
        $student->id_person = R::getInsertID();
        R::store($student);
    } elseif ($person->role == 1) {
        $professor = R::dispense('professor');
        $professor->id_person = R::getInsertID();
    }

} else {
    die(header("HTTP/1.0 400 Bad Request"));
}

?>
