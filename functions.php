<?php

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

// принимает timestamp и возвращает дату в человеческом виде
function show_date($timestamp) {
    $dt = date_create();
    $dt = date_timestamp_set($dt, $timestamp);

    $format = date_format($dt, "d.m.Y H:i");

    return $format;
}

// фильтрует содержимое и возвращает строку, очищенную от опасных спецсимволов
function esc($str) {
    return htmlspecialchars($str);
}
