<?php

session_start();

unset($_SESSION['user']);
unset($_SESSION['error']);

// Ou bien session_destroy();

header("Location:index.php");

