<?php
    use yii\widgets\ActiveForm;

    $this->title = 'Регистрация аккаунта';
    $this->params['breadcrumbs'][] = $this->title;
?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php
            $form = ActiveForm::begin([
                'method' => 'post',
                'options' => ['class' => 'registration__user-form form-create'],
            ]);
        ?>

            <?php
                echo $form->field($model, 'email', [
                    'template' => "{label} {input} <span>Введите валидный адрес электронной почты</span> {error}",
                    'options' => ['tag' => false]
                ])
                    ->label('Электронная почта', ['for' => 'email', 'class' => isset($errors['email']) ? 'input-danger' : ''])
                    ->textInput(['class' => 'input textarea', 'id' => 'email', 'rows' => 1, 'placeholder' => 'kumarm@mail.ru']);
            ?>

            <?php
                echo $form->field($model, 'name', [
                    'template' => "{label} {input} <span>Введите ваше имя и фамилию</span> {error}",
                    'options' => ['tag' => false]
                ])
                    ->label('Ваше имя', ['for' => 'name'])
                    ->textInput(['class' => 'input textarea', 'id' => 'name', 'rows' => 1, 'placeholder' => 'Мамедов Кумар']);
            ?>

            <?php
                echo $form->field($model, 'city', [
                    'template' => '{label} {input} <span>Укажите город, чтобы находить подходящие задачи</span> {error}',
                    'options' => ['tag' => false]
                ])
                    ->label('Город проживания', ['for' => 'city'])
                    ->dropDownList(
                        $cities,
                        [
                            'class' => 'multiple-select input town-select registration-town',
                            'id' => 'city',
                        ]
                    );
            ?>

            <?php
                echo $form->field($model, 'password', [
                    'template' => "{label} {input} <span>Длина пароля от 8 символов</span> {error}",
                    'options' => ['tag' => false]
                ])
                    ->label('Пароль', ['for' => 'password'])
                    ->textInput(['class' => 'input textarea', 'id' => 'password', 'rows' => 1, 'placeholder' => '']);
            ?>

            <button class="button button__registration" type="submit">Создать аккаунт</button>
        <?php ActiveForm::end(); ?>

    </div>
</section>