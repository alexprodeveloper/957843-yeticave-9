<?php
$required_fields = ['lot-name', 'category', 'message', 'lot-img', 'lot-rate', 'lot-step', 'lot-date'];
$errors = [];


foreach ($required_fields as $field ) {
    if(empty($_POST[$field])) {
        $errors[$field] = 'Заполните поле';
    }
}
?>
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category) { ?>
            <li class="nav__item">
                <a href="all-lots.html"><?= $category['name'];?></a>
            </li>
        <?php } ?>
    </ul>
</nav>
<form action="add.php" method="post" class="form form--add-lot container <?= (count($errors)) ? 'form--invalid' : ''; ?> ">  <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?php if(empty($errors[0])) {print 'form__item--invalid';}?>"> <!-- form__item--invalid -->
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $_POST['lot-name']; ?>" >
            <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item <?php if(empty($errors[1])) { print 'class="form__item--invalid'; }?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category">
                <option>Выберите категорию</option>
                <?php foreach ($categories as $category) { ?>
                    <option>
                        <?= $category['name']; ?>
                    </option>
                <?php } ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide <?php if(empty($errors[2])) { print 'form__item--invalid'; }?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$_POST['message']; ?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file <?php if(empty($errors[3])) { print 'form__item--invalid'; }?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" value="" name="lot-img">
            <label for="lot-img">
                Добавить
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?php if(!empty($errors[4])) { print 'form__item--invalid'; }?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= $_POST['lot-rate']; ?>">
            <span class="form__error">Введите начальную цену</span>
        </div>
        <div class="form__item form__item--small <?php if(empty($errors[5])) { print 'form__item--invalid'; }?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= $_POST['lot-step']; ?>">
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <div class="form__item <?php if(empty($errors[6])) { print 'form__item--invalid'; }?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $_POST['lot-date']; ?>">
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
