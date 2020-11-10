<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$student_id = $_POST['id'];
$student = R::load('student', $student_id);
$student->idGroup = NULL;
R::store($student);

?>