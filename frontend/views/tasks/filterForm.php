<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php
$form = ActiveForm::begin([
    'method' => 'get',
    'options' => ['class' => 'search-task__form'],
]);
?>

<fieldset class="search-task__categories">
    <legend>Категории</legend>

    <?php foreach ($categories as $category) {
        $checked = (bool) $selected['categories'][$category->id];

        echo $form->field($model, "category[{$category->id}]", [
            'template' => '{input} {label}',
            'options' => ['tag' => false]
        ])
            ->label($category->name, ['for' => "category_checkbox_{$category->id}"])
            ->checkbox([
                'class' => 'visually-hidden checkbox__input',
                'id' => "category_checkbox_{$category->id}",
                'checked' => $checked
            ], false);
    } ?>
</fieldset>

<fieldset class="search-task__categories">
    <legend>Дополнительно</legend>

    <?php foreach ($model->attributeLabels() as $attr => $label) {
        if ($attr == 'category' || $attr == 'task_name' || $attr == 'period') {
            continue;
        }

        $checked = (bool) $selected['additionals'][$attr];

        echo $form->field($model, $attr, [
            'template' => '{input} {label}',
            'options' => ['tag' => false]
        ])
            ->label($label, ['for' => "additional_checkbox_{$attr}"])
            ->checkbox(
                [
                    'class' => 'visually-hidden checkbox__input',
                    'id' => "additional_checkbox_{$attr}",
                    'checked' => $checked
                ], false
            );
    } ?>
</fieldset>

<?php
    $model->period = $selected['period'];
    echo $form->field($model, 'period', [
        'template' => '{label} {input}',
        'options' => ['tag' => false]
    ])
        ->label('Период', ['for' => 'period', 'class' => 'search-task__name'])
        ->dropDownList(
            ['' => 'За все время', 'day' => 'За день', 'week' => 'За неделю', 'month' => 'За месяц'],
            [
                'class' => 'multiple-select input',
                'id' => 'period',
                'selected' => $model->period
            ],
            false
        );
?>

<?php
    echo $form->field($model, 'task_name', [
        'template' => '{label} {input}',
        'options' => ['tag' => false]
    ])
        ->label('Поиск по имени', ['for' => "search_field", 'class' => 'search-task__name'])
        ->textInput(['class' => 'input-middle input', 'id' => "search_field"], false);
?>

<?php echo Html::submitButton('Искать', ['class' => 'button']) ?>

<?php ActiveForm::end() ?>