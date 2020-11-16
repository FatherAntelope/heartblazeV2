<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$student = R::load('student', $_POST['id']);
$person = R::load('person', $student->idPerson);
R::trash($person);


?>