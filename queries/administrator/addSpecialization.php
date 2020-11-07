<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";

if (R::count('specialization', 'name = ?', [$_POST['nameSpecialization']]) == 0) {
    $specialization = R::dispense('specialization');
    $specialization->name = $_POST['nameSpecialization'];
    R::store($specialization);
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}
?>
