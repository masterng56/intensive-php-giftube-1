<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

print include_template('index.php', [
    'content' => $content,
    'categories' => $categories,
    'gif_list' => $gif_list
]);
