<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

$page_content = include_template('main.php', ['gif_list' => $gif_list]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories
]);

print($layout_content);
