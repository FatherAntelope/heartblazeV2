<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$lesson_id = $_POST['id'];
$normatives = R::find('normative', ' id_lesson = ? ', [$lesson_id]);

echo json_encode($normatives);

?>