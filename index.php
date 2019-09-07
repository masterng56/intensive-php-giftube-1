<?php
require_once 'init.php';

print include_template('index.php', ['content' => $content, 'categories' => $categories, 'gif_list' => $gif_list]);
