<?php
    use yii\widgets\LinkPager;
?>

<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <?php foreach (['rating' => 'Рейтингу', 'orders' => 'Числу заказов', 'popular' => 'Популярности'] as $param => $name){
                $opened = Yii::$app->request->get('sort') == $param;
            ?>
                <li class="user__search-item <?php echo $opened ? 'user__search-item--current' : ''?>">
                    <a href="/<?php echo \Yii::$app->request->getPathInfo() ?>?sort=<?php echo $param?>" class="link-regular"><?php echo $name?></a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <?php foreach ($users as $user) {
        $task_count = \Yii::t(
            'app',
            '{n, plural, =0{# заданий} =1{# задание} one{# задание} few{# заданий} many{# заданий} other{# задания}}',
            ['n' => count($user->tasks0)]
        );

        $opinions_count = \Yii::t(
            'app',
            '{n, plural, =0{# отзывов} =1{# отзыв} one{# отзыв} few{# отзывов} many{# отзывов} other{# отзыва}}',
            ['n' => count($user->opinions0)]
        );
    ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="<?php echo $user->avatar_src ?>" width="65" height="65"></a>
                    <span><?php echo $task_count ?></span>
                    <span><?php echo $opinions_count ?></span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?php echo $user->name ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b><?php echo $user->rating ?></b>
                    <p class="user__search-content">
                        <?php echo $user->about ?>
                    </p>
                </div>
                <span class="new-task__time">Был на сайте <?php echo $user->last_online ?></span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php foreach ($user->usersSpecialties as $specialty) { ?>
                    <a href="#" class="link-regular"><?php echo $specialty->category->name ?></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

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
            ]
        )
        ?>
    </div>
</section>