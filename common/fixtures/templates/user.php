<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$name = $faker->name;
$color = str_replace('#', '', $faker->hexColor());
return [
    'name' => $name,
    'email' => $faker->email,
    'phone' => substr($faker->e164PhoneNumber, 1, 11),
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'city' => rand(1, 10),
    'avatar_src' => "https://via.placeholder.com/360x360.png/{$color}?text={$name}",
    'role' => rand(1, 2),
    'rating' => rand(1, 5).'.'.rand(0, 9),
    'about' => $faker->sentence(),
    'dt_add' =>  $faker->dateTimeBetween('-3 years', '+0 week')->format('Y-m-d H:i:s'),
    'last_online' =>  $faker->dateTimeBetween('-1 week', '+0 week')->format('Y-m-d H:i:s')
];
