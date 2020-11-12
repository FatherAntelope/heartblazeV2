<?php
require $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
$lesson = R::dispense('lesson');
$lesson->id_group = $_POST['group_id'];
$lesson->date = $_POST['lesson_date'];
$lesson->checked = false;
R::store($lesson);

$lessonId = R::getInsertID();
$studentsId = $_POST['students_id'];

if($_POST['lesson_normative'] != '') {
    $normativs_text = explode(",", $_POST['lesson_normative']);
}


R::ext('xdispense', function($table_name){
    return R::getRedBean()->dispense($table_name);
});


foreach ($studentsId as $id) {
    $lessonParticipation = R::xdispense('lesson_participation');
    $lessonParticipation->id_student = $id;
    $lessonParticipation->id_lesson = $lessonId;
    R::store($lessonParticipation);
}

if (count($normativs_text) > 0) {
    foreach ($normativs_text as $text) {
        $normative = R::dispense('normative');
        $normative->id_lesson = $lessonId;
        $normative->text = $text;
        R::store($normative);

        $normativeId = R::getInsertID();

        foreach ($studentsId as $id) {
            $normativeTest = R::xdispense('normative_test');
            $normativeTest->id_normative = $normativeId;
            $normativeTest->id_student = $id;
            R::store($normativeTest);
        }
    }
}
?>