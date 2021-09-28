<?php
    use yii\widgets\LinkPager;
?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>

        <?php foreach ($tasks as $task) {
            $task_date_add = Yii::$app->formatter->format($task->dt_add, 'relativeTime');
        ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="/tasks/<?php echo $task->id?>/" class="link-regular">
                        <h2><?php echo $task->name ?></h2>
                    </a>
                    <a class="new-task__type link-regular" href="#">
                        <p><?php echo $task->category->name ?></p>
                    </a>
                </div>
                <div class="new-task__icon new-task__icon--translation"></div>
                <p class="new-task_description">
                    <?php echo $task->description ?>
                </p>
                <b class="new-task__price new-task__price--translation"><?php echo $task->budget ?><b> ₽</b></b>
                <p class="new-task__place"><?php echo $task->address ?></p>
                <span class="new-task__time"><?php echo $task_date_add ?></span>
            </div>
        <?php } ?>

    </div>

    <div class="new-task__pagination">
        <?php
        echo LinkPager::widget([
            'pagination' => $pagination,
            'options' => [
                'class' => 'new-task__pagination-list',
            ],
            'nextPageLabel' => '',
            'prevPageLabel' => '',
            'nextPageCssClass' => 'pagination__item',
            'prevPageCssClass' => 'pagination__item',
            'pageCssClass' => 'pagination__item',
            'activePageCssClass' => 'pagination__item--current',
        ]);
        ?>
    </div>
</section>

<section class="search-task">
    <div class="search-task__wrapper">
        <?php
            echo $this->render(
                'filterForm',
                [
                    'model' => $model,
                    'categories' => $categories,
                    'selected' => $selected
                ]
            )
        ?>
    </div>
</section>