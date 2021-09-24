<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?php echo $task->name ?></h1>
                    <span>
                        Размещено в категории
                        <a href="#" class="link-regular"><?php echo $task->category->name ?></a>
                        <?php echo $task->dt_add; ?>
                    </span>
                </div>
                <b class="new-task__price new-task__price--<?php echo $task->category->icon ?> content-view-price"><?php echo $task->budget ?><b> ₽</b></b>
                <div class="new-task__icon new-task__icon--<?php echo $task->category->icon ?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p><?php echo $task->description ?></p>
            </div>
            <div class="content-view__attach">
                <h3 class="content-view__h3">Вложения</h3>
                <?php foreach ($task->taskAttachments as $attach) { ?>
                    <a href="<?php echo $attach->file_src ?>"><?php echo $attach->file_name ?></a>
                <?php } ?>
            </div>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#"><img src="/img/map.jpg" width="361" height="292" alt="<?php echo $task->address ?>"></a>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town">Москва</span><br>
                        <span><?php echo $task->address ?></span>
                        <p><?php echo $task->address_comment ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <button class=" button button__big-color response-button open-modal" type="button" data-for="response-form">Откликнуться</button>
            <button class="button button__big-color refusal-button open-modal" type="button" data-for="refuse-form">Отказаться</button>
            <button class="button button__big-color request-button open-modal" type="button" data-for="complete-form">Завершить</button>
        </div>
    </div>

    <div class="content-view__feedback">
        <h2>Отклики <span>(<?php echo count($task->replies) ?>)</span></h2>
        <div class="content-view__feedback-wrapper">

            <?php foreach ($task->replies as $reply) {
                $executor_link = "/users/{$reply->executor->id}/";
                $reply->dt_add = Yii::$app->formatter->format($reply->dt_add, 'relativeTime');
            ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <a href="<?php echo $executor_link ?>"><img src="<?php echo $reply->executor->avatar_src ?>" width="55" height="55"></a>
                        <div class="feedback-card__top--name">
                            <p><a href="<?php echo $executor_link ?>" class="link-regular"><?php echo $reply->executor->name ?></a></p>

                            <?php for ($star = 1; $star <= 5; $star++) { ?>
                                <span class="<?php echo $star > $reply->executor->rating ? 'star-disabled' : '' ?>"></span>
                            <?php } ?>
                            <b><?php echo $reply->executor->rating ?></b>
                        </div>
                        <span class="new-task__time"><?php echo $reply->dt_add ?></span>
                    </div>
                    <div class="feedback-card__content">
                        <p><?php echo $reply->comment ?></p>
                        <span><?php echo $reply->budget ?> ₽</span>
                    </div>
                    <div class="feedback-card__actions">
                        <a class="button__small-color request-button button" type="button">Подтвердить</a>
                        <a class="button__small-color refusal-button button" type="button">Отказать</a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="<?php echo $task->customer->avatar_src ?>" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?php echo $task->customer->name ?></p>
                </div>
            </div>

            <p class="info-customer">
                <span><?php echo $customer->tasks_count ?></span>

                <span class="last-"><?php echo $customer->registrated ?> на сайте</span>
            </p>

            <a href="#" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div id="chat-container">
        <div class="connect-desk__chat">
            <h3>Переписка</h3>
            <div class="chat__overflow"></div>
            <p class="chat__your-message">Ваше сообщение</p>
            <form class="chat__form"><textarea rows="2" name="message-text" placeholder="Текст сообщения" class="input textarea textarea-chat"></textarea> <button type="button" class="button chat__button">Отправить</button></form>
        </div>
    </div>
</section>