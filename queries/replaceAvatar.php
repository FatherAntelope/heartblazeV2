<?php
$person = R::load('person', $_POST['person_id']);
$person->photo = $_POST['person_photo'];
R::store($person);
?>
