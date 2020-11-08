<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
$person = R::load('person', $_POST['professor_id']);
$professor = R::findOne('professor', 'id_person = ?',  [$_POST['professor_id']]);

$person->name = $_POST['professor_name'];
$person->surname = $_POST['professor_surname'];
$person->patronymic = $_POST['professor_patronymic'];

$professor->job = $_POST['professor_job'];

R::store($person);
R::store($professor);
?>