<div class="loginForm">
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?= $_SESSION['message'] ?>
    </div>
    <?php
    unset($_SESSION['message']);
endif; ?>

<form method="post" action="#" autocomplete="off">
    <div class="form-group">
        <label for="email">Логин</label>
        <input name="login" type="text" class="form-control" id="login" placeholder="Введите логин">
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="Введите пароль">
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>
</div>