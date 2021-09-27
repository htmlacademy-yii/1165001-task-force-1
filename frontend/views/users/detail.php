<?php
    $user_last_online = Yii::$app->formatter->format($user->last_online, 'relativeTime');
    $tasks_count = \Yii::t(
        'app',
        '{n, plural, =0{# заказов} =1{# заказ} one{# заказ} few{# заказов} many{# заказов} other{# заказы}}',
        ['n' => count($user->tasks0)]
    );

    $opinions_count = \Yii::t(
        'app',
        '{n, plural, =0{# отзывов} =1{# отзыв} one{# отзыв} few{# отзывов} many{# отзывов} other{# отзыва}}',
        ['n' => count($user->opinions0)]
    );
?>

<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?php echo $user->avatar_src ?>" width="120" height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?php echo $user->name ?></h1>
                <p><?php echo $user->city0->city ?>, 30 лет</p>

                <div class="profile-mini__name five-stars__rate">
                    <?php for ($star = 1; $star <= 5; $star++) { ?>
                        <span class="<?php echo $star > $user->rating ? 'star-disabled' : '' ?>"></span>
                    <?php } ?>
                    <b><?php echo $user->rating ?></b>
                </div>

                <b class="done-task">Выполнил <?php echo $tasks_count ?></b>
                <b class="done-review">Получил <?php echo $opinions_count ?></b>
            </div>

            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span>Был на сайте <?php echo $user_last_online ?></span>
                <a href="#"><b></b></a>
            </div>
        </div>

        <div class="content-view__description">
            <p><?php echo $user->about ?></p>
        </div>

        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Специализации</h3>
                <div class="link-specialization">
                    <?php foreach ($user->usersSpecialties as $specialty) { ?>
                        <a href="#" class="link-regular"><?php echo $specialty->category->name ?></a>
                    <?php } ?>
                </div>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--tel link-regular" href="#"><?php echo $user->phone ?></a>
                    <a class="user__card-link--email link-regular" href="#"><?php echo $user->email ?></a>
                    <a class="user__card-link--skype link-regular" href="#"><?php echo $user->skype ?></a>
                </div>
            </div>
            <div class="user__card-photo">
                <h3 class="content-view__h3">Фото работ</h3>
                <?php foreach ($user->portfolios as $portfolio) { ?>
                    <a href="#"><img src="<?php echo $portfolio->img_src?>" width="85" height="86" alt="Фото работы"></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="content-view__feedback">
        <h2>Отзывы<span>(<?php echo count($user->opinions0) ?>)</span></h2>
        <div class="content-view__feedback-wrapper reviews-wrapper">
            <?php foreach ($user->opinions0 as $opinion) { ?>
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание <a href="/tasks/<?php echo $opinion->task_id ?>/" class="link-regular">«<?php echo $opinion->task->name ?>»</a></p>
                    <div class="card__review">
                        <a href="#"><img src="<?php echo $opinion->sender->avatar_src ?>" width="55" height="54"></a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="#" class="link-regular"><?php echo $opinion->sender->name ?></a></p>
                            <p class="review-text"><?php echo $opinion->description ?></p>
                        </div>
                        <div class="card__review-rate">
                            <p class="five-rate big-rate"><?php echo $opinion->rate ?><span></span></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>