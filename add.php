<?php
require 'helpers.php';
require 'functions.php';
require 'init.php';
require 'data.php';

$post_required_fields = ['name', 'category_id', 'description', 'start_price', 'step', 'ended_at'];
$file_required_fields = ['url'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    foreach ($file_required_fields as $field) {
        if (empty($_FILES[$field])) {
            $errors[$field] = 'Заполните это поле!';
        }
    }
    foreach ($post_required_fields as $field) {
        if (trim($_POST[$field]) == "") {
            $errors[$field] = 'Заполните это поле!';
        }
    }
    $_POST['start_price'] = (int)$_POST['start_price'];
    $_POST['step'] = (int)$_POST['step'];

    if (!is_int($_POST['start_price']) || empty($_POST['start_price'])) {
        $errors['start_price'] = 'Введите число!';
    }

    if (!is_int($_POST['step']) || empty($_POST['step'])) {
        $errors['step'] = 'Введите число!';
    }

    if (!is_date_valid($_POST['ended_at'])) {
        $errors['ended_at'] = "Некорректная дата!";
    }
    if ($_FILES['url']) {
        $tmp_name = $_FILES['url']['tmp_name'];
        $user_file = $_FILES['url']['name'];
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($file_info, $tmp_name);
        if ($file_type != "image/jpeg" && $file_type != "image/png") {
            $errors['url'] = 'Некорректный формат изображения!';
        }
    }

    if (!$errors) {
        $sql = 'INSERT INTO lots (url, category_id, name, start_price, user_id, step, description, ended_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        move_uploaded_file($tmp_name, __DIR__ . '/uploads/' . $user_file);
        setData($con, $sql, [
            $user_file,
            $_POST['category_id'],
            $_POST['name'],
            $_POST['start_price'],
            $_POST['user_id'],
            $_POST['step'],
            $_POST['description'],
            $_POST['ended_at']
        ]);
        header("Location: /index.php");

    }
}
$categories = getDataAll($con, 'SELECT * FROM categories', []);


if ($is_auth == 1) {
    $content = include_template('add.php', ["categories" => $categories, "errors" => $errors]);

} else {
    $content = include_template('not_auth.php', ["categories" => $categories]);
}

$footer = include_template("footer.php", ["categories" => $categories]);
print include_template("layout.php", ["title" => "Добавление лота", "content" => $content, "footer" => $footer]);







