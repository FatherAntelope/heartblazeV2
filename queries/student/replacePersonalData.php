<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
$person = R::load('person', $_POST['student_id']);
$student = R::findOne('student', 'id_person = ?',  [$_POST['student_id']]);

$person->name = $_POST['student_name'];
$person->surname = $_POST['student_surname'];
$person->patronymic = $_POST['student_patronymic'];

$student->group_study = $_POST['student_group_study'];
$student->birth_date = $_POST['student_birth_date'];

R::store($person);
R::store($student);
?>