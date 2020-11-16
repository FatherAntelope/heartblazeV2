<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/frameworks/ChromePhp.php";

$lesson_participation = R::findOne(
    'lesson_participation', ' id_lesson = ? AND id_student = ? ', 
    [$_POST['lesson-id'], $_POST['student-id']]
);

//ChromePhp::log($_POST);
//ChromePhp::log($lesson_participation);

// set pulse
$lesson_participation->pulseBeforeWarmup = $_POST['pulse-before-warmup'];
$lesson_participation->pulseAfterWarmup = $_POST['pulse-after-warmup'];
$lesson_participation->pulseAfterMain = $_POST['pulse-after-main'];
$lesson_participation->pulseAfterFinal = $_POST['pulse-after-final'];
$lesson_participation->pulseAfterRest = $_POST['pulse-after-rest'];

// set time
$lesson_participation->timeOverall = $_POST['time-overall'];
$lesson_participation->timeWarmup = $_POST['time-warmup'];
$lesson_participation->timeMain = $_POST['time-main'];
$lesson_participation->timeFinal = $_POST['time-final'];

// set distance & tracker link
$lesson_participation->distance = $_POST['distance'];
$lesson_participation->trackerLink = $_POST['tracker-link'];

// set status
$lesson_participation->status = 2;

// save lesson data
R::store($lesson_participation);

// save normative
$normatives = R::find('normative', ' id_lesson = ? ', [$_POST['lesson-id']]);
foreach ($normatives as $normative) {
    $normative_test = R::findOne(
        'normative_test', ' id_student = ? AND id_normative = ? ',
        [$_POST['student-id'], $normative->id]
    );
    $score = $_POST['norm-' . $normative->id];
    $normative_test->score = $score;
    R::store($normative_test);
}


?>