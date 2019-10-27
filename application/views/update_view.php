<form class="form-horizontal" action="#" method="post">
    <div class="form-group">
        <label for="inputEmail" class="control-label col-xs-2">Имя пользователя</label>
        <div class="col-xs-10">
            <p class="form-control-static"><?= $data[0]->user_name ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail" class="control-label col-xs-2">Email</label>
        <div class="col-xs-10">
            <p class="form-control-static"><?= $data[0]->email ?></p>
        </div>
    </div>
    <input type="hidden" name="id" value="<?=$data[0]->id?>">
    <div class="form-group">
        <label for="inputPassword" class="control-label col-xs-2">Текст</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" name="text" placeholder="Текст"
                   value="<?=$data[0]->text?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
                <label><input type="checkbox" name="status" <?php if ($data[0]->status) : ?> checked <?php endif; ?>>Выполнено</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary">Редактировать</button>
        </div>
    </div>
</form>
