<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$spec_id = $_POST['id'];
$spec = R::load('specialization', $spec_id);

R::trash($spec);

?>