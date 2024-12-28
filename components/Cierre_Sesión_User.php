<?php

include 'Conectar.php';

session_start();
session_unset();
session_destroy();

header('location:../home.php');

?>