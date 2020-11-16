<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$prof_id = $_POST['id'];
$proffessor = R::load('professor', $prof_id);
$person = R::load('person', $proffessor->idPerson);
R::trash($person);


?>