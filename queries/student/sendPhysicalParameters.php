<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";
R::ext('xdispense', function($table_name){
    return R::getRedBean()->dispense($table_name);
});

$parameters = R::xdispense('student_data');
$parameters->id_student = $_POST['person_id'];
$parameters->date = date("Y-m-d H:i:s");
$parameters->weight = $_POST['student_weight'];
$parameters->height = $_POST['student_height'];
$parameters->quetelet =  $parameters->weight / (($parameters->height * $parameters->height)/100);
$parameters->orthostatic = $_POST['student_orthostatic'];
$parameters->ruffier = $_POST['student_ruffier'];
$parameters->stange = $_POST['student_stange'];
$parameters->tapping_test = $_POST['student_tapping_test'];
$parameters->complaints = ($_POST['student_complaints'] == '') ? null : $_POST['student_complaints'];
$parameters->state_of_health = $_POST['student_state_of_health'];
$parameters->mood = $_POST['student_mood'];
$parameters->sleep = $_POST['student_sleep'];
$parameters->appetite = $_POST['student_appetite'];
$parameters->efficiency = $_POST['student_efficiency'];
R::store($parameters);
?>