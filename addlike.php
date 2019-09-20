<?php
require_once 'init.php';

if (!$config['enable']) {
    $error_msg = "Сайт на техническом обслуживании";
    require_once('off.php');
    exit;
}

$gif_id = intval($_GET['id']) ?? null;

if ($gif_id) {
    // проверяем наличие гифки в избранном
    $sql = "SELECT id FROM gifs_like "
         . "WHERE gif_id = {$gif_id} and user_id = {$_SESSION['user']['id']}";
    $result = mysqli_query($link, $sql);
        
    mysqli_query($link, "START TRANSACTION");
    
    if (mysqli_num_rows($result) > 0) {
        $fav_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $fav_id = intval($fav_list[0]['id']);
        $r1 = mysqli_query($link, "UPDATE gifs SET like_count = like_count - 1 WHERE id = " . $gif_id);
        $r2 = mysqli_query($link, "DELETE FROM gifs_like WHERE id = " . $fav_id);
    }
    else {
        $r1 = mysqli_query($link, "UPDATE gifs SET like_count = like_count + 1 WHERE id = " . $gif_id);
        $r2 = mysqli_query($link, "INSERT INTO gifs_like (gif_id, user_id) VALUES ($gif_id, {$_SESSION['user']['id']})");
    }


    if ($r1 && $r2) {
        mysqli_query($link, "COMMIT");
    }
    else {
        mysqli_query($link, "ROLLBACK");
    }

    header("Location: /view.php?id=" . $gif_id);
    exit;
}
