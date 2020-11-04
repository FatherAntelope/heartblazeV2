<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/db/db.php";
    $specialization = R::dispense('specialization');
    $specialization->name = "dsa";//_GET["spec"]
    R::store($specialization);
?>