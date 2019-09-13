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

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '0';
    $sql = "SELECT gifs.id, gifs.title, gifs.path, gifs.description, gifs.show_count, gifs.like_count, gifs.fav_count, users.name, gifs.category_id FROM gifs_fav "
         . "JOIN gifs ON gifs.id = gifs_fav.gif_id "
         . "JOIN users ON gifs.user_id = users.id "
         . "WHERE gifs_fav.user_id = " . $user_id . " "
         . "ORDER BY gifs_fav.id DESC";

    $result = mysqli_query($link, $sql);

    if ($result) {
        $gif_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $page_content = include_template('favorites.php', ['gif_list' => $gif_list]);
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Избранное | Giftube'
]);

print($layout_content);
