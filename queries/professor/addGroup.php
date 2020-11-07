<?php
require $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
if (R::count('group', 'name = ?', [$_POST['name_group']]) == 0) {
    $group = R::dispense('group');
    $group->name = $_POST['name_group'];
    $group->id_specialization = $_POST['id_specialization'];
    $group->id_professor = $_POST['id_professor'];

    KEYGEN:
    $key = implode('-', str_split(
        substr(
            strtolower(
                md5(microtime().rand(1000, 9999))
            ), 0, 30
        ), 6
    ));

    if(R::count('group', 'code_word = ?', [$key]) == 0) {
        $group->code_word = $key;
    } else {
        goto KEYGEN;
    }

    R::store($group);
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}

?>

