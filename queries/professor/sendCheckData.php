<?php 

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$student_id = $_POST['student_id'];
$lesson_id = $_POST['lesson_id'];

$lesson = R::load('lesson', $_POST['lesson_id']);
$lesson->checked = true;
R::store($lesson);

$lesson_participation = R::findOne(
    'lesson_participation', 'id_student = ? AND id_lesson = ?',
    [$student_id, $lesson_id]
);
if (isset($_POST['student_participation'])) {
    $lesson_participation->status = 1;
} else {
    $lesson_participation->status = 3;
}
R::store($lesson_participation);


$normative_test_ids = [];
$normative_test_scores = [];
foreach($_POST as $key => $value) {
    if (strpos($key, 'score')) {
        $normative_test_scores[] = $value;
    }
    if (strpos($key, 'test')) {
        $normative_test_ids[] = $value;
    }
}

for ($i = 0; $i < count($normative_test_ids); $i++) {
    $normative_test = R::load('normative_test', $normative_test_ids[$i]);
    $normative_test->score = $normative_test_scores[$i];
    R::store($normative_test);
}

?>