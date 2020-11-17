<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$lesson_id = $_POST['id'];
$lesson_participatitions = R::findAll(
    'lesson_participation', 'id_lesson = ?', [$lesson_id] 
);

$result = [];
foreach ($lesson_participatitions as $ls) {
    $student = R::load('student', $ls->idStudent);
    $person = R::load('person', $student->idPerson);
    $normatives = R::findAll(
        'normative', 'id_lesson = ?', [$lesson_id]
    );
    $prepared = [];
    foreach ($normatives as $normative) {
        $normative_test = R::findOne(
            'normative_test', 'id_normative = ? AND id_student = ?', [$normative->id, $student->id]
        );
        $p = array(
            //'normative_id' => $normative->id,
            'normative_test_id' => $normative_test->id,
            'normative_name' => $normative->text,
            'grade' => $normative_test->grade
        );
        $prepared[] = $p;
    }
    $data = array(
        'student_id' => $student->id,
        'fio' => $person->surname . ' ' . $person->name . ' ' . $person->patronymic,
        'lesson_participation' => $ls,
        'prepared' => $prepared
    );
    $result[] = $data;
}

echo json_encode($result);

?>