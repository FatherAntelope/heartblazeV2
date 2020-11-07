<?php
try {
    $person = R::load('person', $_POST['person_id']);
    $person->photo =  file_get_contents($_FILES['person_photo']['C']);
    R::store($person);
} catch (Exception $ex) {
    die(header("HTTP/1.1 401 Unauthorized "));
}

?>
