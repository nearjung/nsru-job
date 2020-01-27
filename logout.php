<?php
session_start();
include_once("include/config.php");
// UPDATE 
session_destroy();
$api->go("../index.php");
?>