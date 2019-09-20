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

    $id = mysqli_real_escape_string($link, $_GET['id']);
    // запрос на показ гифки по ID
    $sql = "SELECT gifs.id, title, path, description, show_count, like_count, users.name, category_id FROM gifs "
         . "JOIN users ON gifs.user_id = users.id "
         . "WHERE gifs.id = '%s'";

    $sql = sprintf($sql, $id);
    if ($result = mysqli_query($link, $sql)) {

        if (!mysqli_num_rows($result)) {
            http_response_code(404);
            $page_content = include_template('error.php', ['error' => 'Гифка с этим идентификатором не найдена']);
        }
        else {
            $gif = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // запрос на поиск похожих гифок
            $sql = "SELECT gifs.id, title, path, description, show_count, like_count, users.name FROM gifs "
                 . "JOIN users ON gifs.user_id = users.id "
                 . "WHERE category_id = " . $gif['category_id'] . " LIMIT 3";

            $result = mysqli_query($link, $sql);
            $sim_gifs = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // избранное пользователя
            $sql = "SELECT id FROM gifs_fav WHERE gif_id = $id AND user_id = " . $_SESSION['user']['id'];
            $result = mysqli_query($link, $sql);
            $is_fav = mysqli_num_rows($result) > 0;

            // лайки пользователя
            $sql = "SELECT id FROM gifs_like WHERE gif_id = $id AND user_id = " . $_SESSION['user']['id'];
            $result = mysqli_query($link, $sql);
            $is_liked = mysqli_num_rows($result) > 0;

            // передаем в шаблон результат выполнения
            $page_content = include_template('view.php', [
                'gif' => $gif,
                'sim_gifs' => $sim_gifs,
                'comments' => $comments,
                'is_liked' => $is_liked,
                'is_fav' => $is_fav
            ]);

        }
    }
    else {
        show_error($content, mysqli_error($link));
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'GifTube - Просмотр гифки'
]);

print($layout_content);
