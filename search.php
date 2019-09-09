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
    $sql = 'SELECT id, name FROM categories';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }

    $search = trim($_GET['q']) ?? '';

    if (!strlen($search)) {
        $page_content = include_template('search.php', ['gif_list' => []]);
    }
    else {
        $search = "%" . $search . "%";

        // запрос на поиск гифок по имени или описанию
        $sql = "SELECT g.id, title, path, like_count, u.name FROM gifs g "
          . "JOIN users u ON g.user_id = u.id "
          . "WHERE `title` LIKE ? OR `description` LIKE ?";

        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $search, $search);
        mysqli_stmt_execute($stmt);

        if ($gif_list = mysqli_stmt_get_result($stmt)) {
            $gif_list = mysqli_fetch_all($gif_list, MYSQLI_ASSOC);
            // передаем в шаблон результат выполнения
            $page_content = include_template('search.php', ['gif_list' => $gif_list]);
        }
        else {
            $page_content = include_template('error.php', ['error' => mysqli_error($link)]);
        }
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Поиск гифок | Giftube'
]);

print($layout_content);
