<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
}
else {
    // получаем категории
    $sql = 'SELECT `id`, `name` FROM categories';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }

    // запрос на показ гифок в зависимости от выбора
    // "Топовые гифки" или "Свежачок"
    $sort_field = 'show_count';

    if (isset($_GET['tab']) && $_GET['tab'] == 'new') {
        $sort_field = 'dt_add';
    }

    $sql = 'SELECT gifs.dt_add, gifs.id, title, path, like_count, users.name FROM gifs '
         . 'JOIN users ON gifs.user_id = users.id '
         . 'ORDER BY ' . $sort_field . ' DESC LIMIT 6';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $gif_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $page_content = include_template('main.php', ['gif_list' => $gif_list]);
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница | Giftube'
]);

print($layout_content);
