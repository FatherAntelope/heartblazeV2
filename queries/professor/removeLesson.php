<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$lessonn_id = $_POST['id'];
$lesson = R::load('lesson', $lessonn_id);
R::trash($lesson);

?>