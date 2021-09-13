<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class CityFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\Cities';
    public $dataFile = '@common/fixtures/data/city.php';
}
