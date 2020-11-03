<?php

setcookie('userID', '', time() - (60*60*24*30), "/");
setcookie('role',   '', time() - (60*60*24*30), "/");

header("Location: http://".$_SERVER['HTTP_HOST']);

?>