<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$prof_id = $_POST['id'];

$request = R::findOne('request', 'id_professor = ? ', [$prof_id]);

$certificate = $request->certificate;

echo base64_encode($certificate);

?>