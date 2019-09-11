<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;

        $required = ['email', 'password'];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить ' . $key;
            }
        }

        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!count($errors) and $user) {
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            }
            else {
                $errors['password'] = 'Неверный пароль';
            }
        }
        else {
            $errors['email'] = 'Такой пользователь не найден';
        }

        // если есть ошибки валидации, выводим ошибки и переданные данные
        if (count($errors)) {
            $page_content = include_template('signin.php', [
                'form' => $form,
                'errors' => $errors
            ]);
        }
        else {
            header("Location: /index.php");
            exit();
        }
    }
    else {
        
        if (isset($_SESSION['user'])) {
            header("Location: /index.php");
            exit();
        }

        $page_content = include_template('signin.php', ['categories' => $categories]);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Добавить гифку | Giftube'
]);

print($layout_content);
