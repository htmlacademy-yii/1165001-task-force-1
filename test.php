<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once('vendor/autoload.php');

    use TaskForce\Actions\Task;

    $data = array(
        'executor_id' => '123',
        'client_id' => '321',
        'due_date' => '30.07.2020',
        'active_status' => 'cancel'
    );

    $Task = new Task($data);

    $action = Task::ACTIONS['cancel'];
    $status = $Task->statusSwitcher($action);
    if ($status !== Task::STATUSES['canceled']){
        echo 'Неверный статус, должен быть «'.Task::STATUSES['canceled'].'»<br>';
    } else {
        echo '«'.Task::STATUSES['canceled'].'» - Проверка прошла успешно!<br>';
    }

    $action = Task::ACTIONS['accept'];
    $status = $Task->statusSwitcher($action);
    if ($status !== Task::STATUSES['in_progress']){
        echo 'Неверный статус, должен быть «'.Task::STATUSES['in_progress'].'»<br>';
    } else {
        echo '«'.Task::STATUSES['in_progress'].'» - Проверка прошла успешно!<br>';
    }

    $action = Task::ACTIONS['complete'];
    $status = $Task->statusSwitcher($action);
    if ($status !== Task::STATUSES['completed']){
        echo 'Неверный статус, должен быть «'.Task::STATUSES['completed'].'»<br>';
    } else {
        echo '«'.Task::STATUSES['completed'].'» - Проверка прошла успешно!<br>';
    }

    $action = Task::ACTIONS['reject'];
    $status = $Task->statusSwitcher($action);
    if ($status !== Task::STATUSES['failed']){
        echo 'Неверный статус, должен быть «'.Task::STATUSES['failed'].'»<br>';
    } else {
        echo '«'.Task::STATUSES['failed'].'» - Проверка прошла успешно!<br>';
    }