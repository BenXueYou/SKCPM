<?php

require_once "../con.php";

$msg = $_POST["msg"];

$loggle = new Loggle();

$loggle->logs($msg);



echo true;

?>