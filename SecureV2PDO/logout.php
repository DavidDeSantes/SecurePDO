<?php

session_start();

unset($_SESSION['user']);
unset($_SESSION['user']);

// Ou bien session_destroy();

header("Location:index.php");

