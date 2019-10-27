<?php
if (isset($_SESSION['create_task'])) : ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?= $_SESSION['create_task'] ?>
    </div>
    <?php
endif; ?>
<form class="form-horizontal" action="#" method="post">
    <div class="form-group">
        <label for="name" class="control-label col-xs-2">Имя пользователя</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" name="user_name" required placeholder="Имя пользователя">
</div>
</div>
<div class="form-group">
    <label for="inputEmail" class="control-label col-xs-2">Email</label>
    <div class="col-xs-10">
        <input type="email" class="form-control" name="email" required placeholder="Email">
    </div>
</div>
<div class="form-group">
    <label for="inputPassword" class="control-label col-xs-2">Текст</label>
    <div class="col-xs-10">
        <input type="text" class="form-control" name="text" placeholder="Текст">
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
        <button type="submit" class="btn btn-primary">Создать</button>
    </div>
</div>
</form>
