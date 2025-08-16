<?php
require_once "Task.php";

const COLOR_GREEN = "[32m";
const COLOR_RED = "[31m";
const COLOR_RESET = "[0m";
const COLOR_YELLOW = "[33m";

function runTest(string $testName, callable $testFunction): void
{
    echo COLOR_RESET . $testName . "\n";
    try {
        $result = $testFunction();
        if ($result) {
            echo COLOR_GREEN . "PASS\n";
        } else {
            echo COLOR_RED . "FAIL\n";
        }
    } catch (Exception $e) {
        echo COLOR_RED . "ERROR: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// 1. Test fromArray()
runTest("1.- Método fromArray()", function () {
    $data = [
        'id' => 1,
        'tittle' => 'Lavar trastes',
        'description' => 'No los rompas',
        'status' => Task::STATUS_DONE
    ];
    $task = Task::fromArray($data);
    return $task->getId() === 1 &&
        $task->getTittle() === 'Lavar trastes' &&
        $task->getDescription() === 'No los rompas' &&
        $task->getStatus() === Task::STATUS_DONE;
});

// 2. Test __toString()
runTest("2.- Método __toString()", function () {
    $task = new Task();
    $task->setId(1);
    $task->setTittle("Test Title");
    $task->setDescription("Test Description");
    $task->setStatus(Task::STATUS_PENDING);
    $expected = "Id: 1 Titulo: Test Title Descripcion: Test Description Estatus: Pendiente";
    return (string) $task === $expected;
});

// 3. Test Setters and Getters
runTest("3.- Métodos set/get", function () {
    $task = new Task();
    $task->setId(10);
    $task->setTittle("Buy milk");
    $task->setDescription("Get 2% milk");
    $task->setStatus(Task::STATUS_IN_PROGRESS);

    return $task->getId() === 10 &&
        $task->getTittle() === "Buy milk" &&
        $task->getDescription() === "Get 2% milk" &&
        $task->getStatus() === Task::STATUS_IN_PROGRESS;
});


// 4. Test markInProgress()
runTest("4.- Método markInProgress()", function () {
    $task = new Task();
    $task->setDescription("test");
    $task->markInProgress();
    return $task->getStatus() === Task::STATUS_IN_PROGRESS;
});

// 5. Test markDone()
runTest("5.- Método markDone()", function () {
    $task = new Task();
    $task->setDescription("test");
    $task->markDone();
    return $task->getStatus() === Task::STATUS_DONE;
});

// 6. Test toArray()
runTest("6.- Método toArray()", function () {
    $task = new Task();
    $task->setId(5);
    $task->setTittle("Test toArray");
    $task->setDescription("Description for toArray");
    $task->setStatus(Task::STATUS_DONE);
    $expected = [
        'id' => 5,
        'tittle' => 'Test toArray',
        'description' => 'Description for toArray',
        'status' => Task::STATUS_DONE,
    ];
    return $task->toArray() === $expected;
});

// 7. Test validateStatus() with invalid status
runTest("7.- Método validateStatus() con estatus inválido", function () {
    $task = new Task();
    $task->setDescription("test");
    try {
        $task->setStatus(99); // Invalid status
    } catch (Exception $e) {
        return $e->getMessage() === "El estatus : 99 es invalido";
    }
    return false;
});

// 8. Test validateStatus() with null status
runTest("8.- Método validateStatus() con estatus nulo", function () {
    $task = new Task();
    $task->setDescription("test");
    try {
        $task->setStatus(null);
    } catch (Exception $e) {
        return $e->getMessage() === "Indique almenos un estatus";
    }
    return false;
});

// 9. Test getStatusString()
runTest("9.- Método getStatusString()", function () {
    $task = new Task();
    $task->setDescription("test");
    $task->setStatus(Task::STATUS_PENDING);
    $isPending = $task->getStatusString() === 'Pendiente';

    $task->setStatus(Task::STATUS_IN_PROGRESS);
    $isInProgress = $task->getStatusString() === 'En progreso';

    $task->setStatus(Task::STATUS_DONE);
    $isDone = $task->getStatusString() === 'Realizado';

    return $isPending && $isInProgress && $isDone;
});