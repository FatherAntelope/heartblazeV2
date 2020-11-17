<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$student_id = $_POST['id'];
$student_data = R::findOne('student_data', ' id_student = ? ', [$student_id]);

echo json_encode($student_data);

?>