<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class TaskFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\Tasks';
    public $dataFile = '@common/fixtures/data/task.php';
}
