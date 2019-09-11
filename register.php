<?php
require_once('init.php');

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

$tpl_data = [];

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $errors = [];

        $req_fields = ['email', 'password', 'name'];

        foreach ($req_fields as $field) {
            if (empty($form[$field])) {
                $errors[] = "Не заполнено поле " . $field;
            }
        }

        if (empty($errors)) {
            $email = mysqli_real_escape_string($link, $form['email']);
            $sql = "SELECT id FROM users WHERE email = '$email'";
            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) > 0) {
                $errors[] = 'Пользователь с этим email уже зарегистрирован';
            }
            else {
                $password = password_hash($form['password'], PASSWORD_DEFAULT);

                $sql = 'INSERT INTO users (dt_add, email, name, password) VALUES (NOW(), ?, ?, ?)';
                $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password]);
                $result = mysqli_stmt_execute($stmt);
            }

            if ($result && empty($errors)) {
                header("Location: /index.php");
                exit();
            }
        }

        $tpl_data['errors'] = $errors;
        $tpl_data['values'] = $form;
    }
}


$page_content = include_template('reg.php', $tpl_data);

$layout_content = include_template('layout.php', [
    'content'    => $page_content,
    'categories' => $categories,
    'title'      => 'Регистрация | Giftube'
]);

print($layout_content);
