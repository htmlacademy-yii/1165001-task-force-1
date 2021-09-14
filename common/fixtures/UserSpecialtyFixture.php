<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UserSpecialtyFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\UsersSpecialty';
    public $dataFile = '@common/fixtures/data/user_specialty.php';
}
