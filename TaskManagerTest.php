<?php
require_once "TaskManager.php";
require_once "Task.php";

const COLOR_GREEN = "[32m";
const COLOR_RED = "[31m";
const COLOR_RESET = "[0m";

function runTest(string $testName, callable $testFunction): void
{
    echo COLOR_RESET . $testName . "
";
    try {
        $result = $testFunction();
        if ($result) {
            echo COLOR_GREEN . "PASS
";
        } else {
            echo COLOR_RED . "FAIL
";
        }
    } catch (Exception $e) {
        echo COLOR_RED . "ERROR: " . $e->getMessage() . "
";
    }
    echo "
";
}

// 1. Test addTask() and countTasks()
runTest("1.- Método addTask() y countTasks()", function () {
    $taskManager = new TaskManager();
    $task = new Task();
    $task->setDescription("test");
    $taskManager->addTask($task);
    return $taskManager->countTasks() === 1;
});

// 2. Test getAllTasks()
runTest("2.- Método getAllTasks()", function () {
    $taskManager = new TaskManager();
    $task1 = new Task();
    $task1->setDescription("test1");
    $task2 = new Task();
    $task2->setDescription("test2");
    $taskManager->addTask($task1);
    $taskManager->addTask($task2);
    $tasks = $taskManager->getAllTasks();
    return count($tasks) === 2 && $tasks[0] === $task1 && $tasks[1] === $task2;
});

// 3. Test getTaskById()
runTest("3.- Método getTaskById()", function () {
    $taskManager = new TaskManager();
    $task = new Task();
    $task->setDescription("test");
    $taskManager->addTask($task); // ID will be 1
    $foundTask = $taskManager->getTaskById($task->getId());
    return $foundTask !== null && $foundTask->getId() === $task->getId();
});

// 4. Test getTaskById() with non-existent ID
runTest("4.- Método getTaskById() con ID inexistente", function () {
    $taskManager = new TaskManager();
    $foundTask = $taskManager->getTaskById(99);
    return $foundTask === null;
});

// 5. Test toArray()
runTest("5.- Método toArray()", function () {
    $taskManager = new TaskManager();
    $task = new Task();
    $task->setTittle("Test toArray");
    $task->setDescription("Description");
    $task->setStatus(Task::STATUS_PENDING);
    $taskManager->addTask($task);

    $expected = [
        'tittle' => 'Test toArray',
        'description' => 'Description',
        'status' => Task::STATUS_PENDING,
    ];
    $isValid = false;
    if (
        $task->getStatus() === Task::STATUS_PENDING &&
        $task->getDescription() == $expected['description'] &&
        $task->getTittle() == $expected['tittle']
    ) {
        $isValid = true;
    }
    return $isValid;
});


// 6. Test getTasksByStatus()
runTest("6.- Método getTasksByStatus()", function () {
    $taskManager = new TaskManager();

    $task1 = new Task();
    $task1->setDescription("pending");
    $task1->setStatus(Task::STATUS_PENDING);
    $taskManager->addTask($task1);

    $task2 = new Task();
    $task2->setDescription("in progress");
    $task2->setStatus(Task::STATUS_IN_PROGRESS);
    $taskManager->addTask($task2);

    $task3 = new Task();
    $task3->setDescription("done");
    $task3->setStatus(Task::STATUS_DONE);
    $taskManager->addTask($task3);

    $pendingTasks = $taskManager->getTasksByStatus(Task::STATUS_PENDING);
    $inProgressTasks = $taskManager->getTasksByStatus(Task::STATUS_IN_PROGRESS);
    $doneTasks = $taskManager->getTasksByStatus(Task::STATUS_DONE);

    return count($pendingTasks) === 1 && $pendingTasks[0]->getDescription() === "pending" &&
        count($inProgressTasks) === 1 && $inProgressTasks[0]->getDescription() === "in progress" &&
        count($doneTasks) === 1 && $doneTasks[0]->getDescription() === "done";
});

// 7. Test addTask() with existing ID (update)
runTest("7.- Método addTask() con ID existente (actualización)", function () {
    $taskManager = new TaskManager();
    $task = new Task();
    $task->setDescription("Initial");
    $taskManager->addTask($task);

    $updatedTask = new Task();
    $updatedTask->setId($task->getId());
    $updatedTask->setDescription("Updated");
    $taskManager->addTask($updatedTask);

    $retrievedTask = $taskManager->getTaskById($updatedTask->getId());
    return $taskManager->countTasks() === 1 && $retrievedTask->getDescription() === "Initial";
});
