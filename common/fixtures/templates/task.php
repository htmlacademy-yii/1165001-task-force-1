<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$executor = rand(1, 20);
$customer = rand(1, 20);

// отбраковка повторений
if ($customer === $executor){
    while ($customer === $executor) {
        $customer = rand(1, 20);
    }
}

return [
    'dt_add' => $faker->dateTimeBetween('-2 months', '+0 week')->format('Y-m-d H:i:s'),
    'category_id' => rand(1, 8),
    'description' => $faker->sentence(),
    'expire' => $faker->dateTimeBetween('-0 week', '+1 month')->format('Y-m-d H:i:s'),
    'name' => $faker->sentence(rand(2, 4)),
    'address' => $faker->address,
    'budget' => rand(1000, 10000),
    'customer_id' => $customer,
    'executor_id' => $executor,
];
