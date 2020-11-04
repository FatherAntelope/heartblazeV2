<?php
require_once $_SERVER['DOCUMENT_ROOT']."/db/db.php";
$specialization = R::dispense('specialization');
$specialization->name = $_POST['nameSpecialization'];
R::store($specialization);
?>
