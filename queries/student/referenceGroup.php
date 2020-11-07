<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
$group = R::findOne('group', 'code_word = ? ', [$_POST['code_word']]);
if($group) {
    $student = R::findOne('student', 'id_person = ?', [$_POST['student_id']]);
    $student->id_group = $group->id;
    R::store($student);
} else {
    die(header("HTTP/1.0 400 Bad Request"));
}

?>
