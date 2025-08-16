<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
</head>
<body>
    <h1>Demostración del Gestor de Tareas</h1>

    <?php
    require_once "Task.php";
    require_once "TaskManager.php";

    $taskManager = new TaskManager();
    ?>

    <hr>

    <h2>1. Creación de una nueva tarea</h2>
    <p>Creamos una nueva tarea con el título "Lavar ropa".</p>
    <?php
    $task = Task::fromArray([
        'id' => null,
        'tittle' => 'Lavar ropa',
        'description' => 'utiliza suavizante',
        'status' => Task::STATUS_PENDING,
    ]);
    ?>
    <p><strong>Datos de la tarea creada (antes de agregarla al gestor):</strong></p>
    <pre><?php print_r($task->toArray()); ?></pre>
    <p>Se observa que el registro tiene asignado el Id `null`. Al momento de agregarlo a la colección se le asignará un ID.</p>

    <?php $taskManager->addTask($task); ?>
    
    <h2>2. Agregar la tarea al gestor</h2>
    <p>Después de agregar la tarea, el gestor le asigna un ID. Aquí está la lista de todas las tareas:</p>
    <pre><?php print_r($taskManager->getAllTasks()); ?></pre>

    <hr>

    <h2>3. Búsqueda y actualización de una tarea</h2>
    <p>Teniendo el ID (1), podemos buscarlo con el método `getTaskById()` y verificar su estatus.</p>
    <?php $recoverTask = $taskManager->getTaskById(1); ?>
    <p>Estatus inicial: <strong><?php echo $recoverTask->getStatusString(); ?></strong></p>
    <pre><?php print_r($recoverTask); ?></pre>

    <p>Podemos cambiar el estatus a "Realizado":</p>
    <?php $recoverTask->markDone(); ?>
    <p>Nuevo estatus: <strong><?php echo $recoverTask->getStatusString(); ?></strong></p>
    <pre><?php print_r($recoverTask); ?></pre>

    <p>Y también podemos cambiar el estatus a "En progreso":</p>
    <?php $recoverTask->markInProgress(); ?>
    <p>Estatus final: <strong><?php echo $recoverTask->getStatusString(); ?></strong></p>
    <pre><?php print_r($recoverTask); ?></pre>

    <hr>

    <h2>4. Conteo y adición de más tareas</h2>
    <p>Podemos obtener el total de tareas actual.</p>
    <p>Total de tareas: <strong><?php echo $taskManager->countTasks(); ?></strong></p>

    <p>Ahora, vamos a agregar 4 tareas más.</p>
    <?php
    $data = [
        ['id' => null, 'tittle' => 'Lavar trastes', 'description' => 'No los rompas', 'status' => Task::STATUS_DONE],
        ['id' => null, 'tittle' => 'Tender la cama', 'description' => 'bien estirada', 'status' => Task::STATUS_IN_PROGRESS],
        ['id' => null, 'tittle' => 'Barrer', 'description' => 'también debajo de los muebles', 'status' => Task::STATUS_PENDING],
        ['id' => null, 'tittle' => 'Cortar el pasto', 'description' => 'Usa sombrero', 'status' => Task::STATUS_PENDING]
    ];

    foreach ($data as $taskData) {
        $task = Task::fromArray($taskData);
        $taskManager->addTask($task);
    }
    ?>
    <p><strong>Lista de todas las tareas después de agregar las nuevas:</strong></p>
    <pre><?php print_r($taskManager->getAllTasks()); ?></pre>
    <p>El nuevo total de tareas es:</p>
    <p>Total de tareas: <strong><?php echo $taskManager->countTasks(); ?></strong></p>

    <hr>
    
    <h2>5. Filtrado de tareas por estatus</h2>
    <p>Podemos ver la lista de todos los estatus disponibles:</p>
    <pre><?php print_r(Task::$statuses); ?></pre>

    <h3>Tareas con estatus: Pendiente</h3>
    <pre><?php print_r($taskManager->getTasksByStatus(Task::STATUS_PENDING)); ?></pre>

    <h3>Tareas con estatus: Realizado</h3>
    <pre><?php print_r($taskManager->getTasksByStatus(Task::STATUS_DONE)); ?></pre>

    <h3>Tareas con estatus: En Progreso</h3>
    <pre><?php print_r($taskManager->getTasksByStatus(Task::STATUS_IN_PROGRESS)); ?></pre>

</body>
</html>