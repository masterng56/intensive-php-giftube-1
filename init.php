<?php
session_start();

require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';
$db = require_once 'config/db.php';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

$content = '';
$categories = [];

// var_dump($_SESSION);
