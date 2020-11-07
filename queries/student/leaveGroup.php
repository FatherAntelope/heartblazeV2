<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
$student = R::findOne('student', 'id_person = ?', [$_POST['student_id']]);
$student->id_group = null;
R::store($student);
?>
