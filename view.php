<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

$page_content = include_template('view.php', ['comments' => $comments]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => [],
    'title' => 'GifTube - Просмотр гифки'
]);

print($layout_content);
