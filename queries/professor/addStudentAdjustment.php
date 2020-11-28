<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$studentData = R::findOne('lesson_participation', 'id_student = ? AND id_lesson = ? AND status = 3', [$_POST['student_id'], $_POST['lesson_id']]);

if(count($studentData) > 0) {
    $studentData->status = 1;
    R::store($studentData);
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}

?>
