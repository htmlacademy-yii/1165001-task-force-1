<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    assert_options(ASSERT_ACTIVE, true);

    require_once('vendor/autoload.php');

    use TaskForce\models\Task;

    $task = new Task(123, 321);
    $tests = $errors = 0;

    assertValue($task->getStatusId() === Task::STATUS_NEW, 'Default Status', $tests, $errors);
    assertValue($task->getAvailableActions() === [Task::ACTION_CANCEL, Task::ACTION_REPLY],
        'Available actions for STATUS_NEW', $tests, $errors);

    // Проверка статусов
    $task->cancel();
    assertValue($task->getStatusId() === Task::STATUS_CANCELLED, 'Cancel Action', $tests, $errors);

    $task->reply();
    assertValue($task->getStatusId() === Task::STATUS_IN_PROGRESS, 'Reply Action', $tests, $errors);
    assertValue($task->getAvailableActions() === [Task::ACTION_COMPLETE, Task::ACTION_REFUSE],
        'Available actions for STATUS_IN_PROGRESS', $tests, $errors);

    $task->complete();
    assertValue($task->getStatusId() === Task::STATUS_COMPLETED, 'Complete Action', $tests, $errors);

    $task->refuse();
    assertValue($task->getStatusId() === Task::STATUS_FAILED, 'Refuse Action', $tests, $errors);


    // Проверка работы функции getStatusAfterAction
    $statusName = $task::getStatusAfterAction($task::ACTION_CANCEL);
    $statusName2 = $task->getStatusName($task::STATUS_CANCELLED);
    assertValue($statusName === $statusName2, 'Task::getStatusAfterAction(cancel)', $tests, $errors);

    $statusName = Task::getStatusAfterAction(Task::ACTION_REPLY);
    $statusName2 = $task->getStatusName(Task::STATUS_IN_PROGRESS);
    assertValue($statusName === $statusName2, 'Task::getStatusAfterAction(reply)', $tests, $errors);

    $statusName = Task::getStatusAfterAction(Task::ACTION_COMPLETE);
    $statusName2 = $task->getStatusName(Task::STATUS_COMPLETED);
    assertValue($statusName === $statusName2, 'Task::getStatusAfterAction(complete)', $tests, $errors);

    $statusName = Task::getStatusAfterAction(Task::ACTION_REFUSE);
    $statusName2 = $task->getStatusName(Task::STATUS_FAILED);
    assertValue($statusName === $statusName2, 'Task::getStatusAfterAction(refuse)', $tests, $errors);

    echo "<br /> Job's done. Total tests - $tests, Errors - $errors";

    function assertValue(bool $value, string $description, &$tests, &$errors)
    {
        $tests++;
        $errors += (int) !assert($value, $description);
    }
