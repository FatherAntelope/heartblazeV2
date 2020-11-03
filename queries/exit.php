<?php

setcookie('person_ID', '', time() - (60*60*24*30), "/");
setcookie('person_role',   '', time() - (60*60*24*30), "/");

header("Location: http://".$_SERVER['HTTP_HOST']);

?>