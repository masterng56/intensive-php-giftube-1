<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

$cats_ids = []; // для валидации категорий

if (!$link) {
    $error = mysqli_connect_error();
    show_error($content, $error);
}
else {
    $sql = 'SELECT `id`, `name` FROM categories';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $cats_ids = array_column($categories, 'id');
    }
    else {
        $error = mysqli_error($link);
        show_error($content, $error);
    }

    $page_content = include_template('add.php', ['categories' => $categories]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $gif = $_POST;

        $required = ['title', 'description', 'category_id'];
        $errors = [];

        $rules = [
            'category_id' => function() use ($cats_ids) {
                return validateCategory('category_id', $cats_ids);
            },
            'title' => function() {
                return validateLength('title', 10, 200);
            },
            'description' => function() {
                return validateLength('description', 10, 3000);
            }
        ];

        foreach ($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule();
            }
        }

        $errors = array_filter($errors);

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        if (!empty($_FILES['gif_img']['name'])) {
            $tmp_name = $_FILES['gif_img']['tmp_name'];
            $path = $_FILES['gif_img']['name'];
            $filename = uniqid() . '.gif';

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== "image/gif") {
                $errors['file'] = 'Загрузите картинку в формате GIF';
            }
            else {
                move_uploaded_file($tmp_name, 'uploads/' . $filename);
                $gif['path'] = $filename;
            }
        }
        else {
            $errors['file'] = 'Вы не загрузили файл';
        }

        // если есть ошибки валидации, выводим ошибки и переданные данные
        if (count($errors)) {
            $page_content = include_template('add.php', [
                'gif' => $gif,
                'errors' => $errors,
                'categories' => $categories
            ]);
        }
        else {

            $sql = 'INSERT INTO gifs (dt_add, category_id, user_id, title, description, path) VALUES (NOW(), ?, 1, ?, ?, ?)';

            $stmt = db_get_prepare_stmt($link, $sql, $gif);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $gif_id = mysqli_insert_id($link);

                header("Location: view.php?id=" . $gif_id);
            }
            else {
                $page_content = include_template('error.php', ['error' => mysqli_error($link)]);
            }
        }
    }
    else {
        $page_content = include_template('add.php', ['categories' => $categories]);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Добавить гифку | Giftube'
]);

print($layout_content);