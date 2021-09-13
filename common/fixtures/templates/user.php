<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'name' => $faker->name,
    'email' => $faker->email,
    'phone' => substr($faker->e164PhoneNumber, 1, 11),
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'city' => rand(1, 10)
];
