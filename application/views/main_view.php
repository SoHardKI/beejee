<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 1;
}
if (!isset($_SESSION['admin'])) : ?>
    <form action="/admin/index" method="post">
        <button class="btn btn-primary">Вход для администратора</button>
    </form>
<?php else: ?>
    <?php if ($_SESSION['admin'] == true) : ?>
        <h4>Вы вошли как администратор</h4>
        <form action="/admin/logout" method="post">
            <button class="btn btn-danger">Выйти</button>
        </form>
    <?php else: ?>
        <form action="/admin/index">
            <button class="btn btn-primary">Вход для администратора</button>
        </form>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_SESSION['create_task'])) : ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?= $_SESSION['create_task'] ?>
    </div>
    <?php
    unset($_SESSION['create_task']); ?>
<?php endif; ?>
<?php
//работа с пагинацией
$per_page = 3;
$db = new \application\models\model_main();
$count = $db->getCounttasks();
$curr_page = 1;
if (isset($_SESSION['page']) && $_SESSION['page'] > 0) {
    $curr_page = $_SESSION['page'];
}
$start = ($curr_page - 1) * $per_page;
$num_pages = ceil($count / $per_page);
$page = 0;
?>
<h2 align="center">Список задач</h2>
<div class="sort-div">
    <form action="/main/index" method="post">
        <button class="btn btn-secondary" name="sort" value="user_name">Сортировать по имени</button>
    </form>
    <form class="sort-btn" action="/main/index" method="post">
        <button class="btn btn-secondary" name="sort" value="email">Сортировать по email</button>
    </form>
    <form class="sort-btn" action="/main/index" method="post">
        <button class="btn btn-secondary" name="sort" value="status">Сортировать по статусу</button>
    </form>
</div>
<table class="table table-bordered">
    <thead>
    <tr>
        <?php if (isset($_SESSION['admin'])) : ?>
            <th></th>
        <?php endif; ?>
        <th>Имя пользователя</th>
        <th>Email</th>
        <th>Текст задачи</th>
        <th>Статус задачи</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $task) : ?>
        <tr>
            <?php if (isset($_SESSION['admin'])) : ?>
                <td>
                    <form action="/main/update" method="post">
                        <input type="hidden" name="id" value="<?= $task['id'] ?>">
                        <button class="btn btn-success">Редактировать</button>
                    </form>
                </td>
            <?php endif; ?>
            <td><?= $task['user_name'] ?></td>
            <td><?= $task['email'] ?></td>
            <td><?= $task['text'] ?></td>
            <td><?= $task['status'] ? 'выполнено' : 'невыполнено' ?></td>
            <?php if ($task['admin']) : ?>
                <td><?= 'отредактировано администратором' ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <form action="/main/index/page=1" method="post">
        <button class="btn btn-secondary btn-paginator" name="page" value="1"><?= 'Первая страница' ?></button>
    </form>
    <?php
    //вывод пагинации
    for ($i = 1;
         $i <= $num_pages;
         $i++) : ?>
        <form action="/main/index/page=<?= $i ?>" method="post">
            <?php if ($i == $curr_page) : ?>
                <button class="btn btn-primary btn-paginator" name="page" value="<?= $i ?>"><?= $i ?></button>
            <?php else: ?>
                <button class="btn btn-second btn-paginator" name="page" value="<?= $i ?>"><?= $i ?></button>
            <?php endif; ?>
        </form>
    <?php endfor; ?>
    <form action="/main/index/page=<?= $num_pages ?>" method="post">
        <button class="btn btn-secondary btn-paginator" name="page"
                value="<?= $num_pages ?>"><?= 'Последняя страница' ?></button>
    </form>
</div>


<form class="form-create" action="/main/create" method="post">
    <button class="btn btn-success">Создать задачу</button>
</form>




