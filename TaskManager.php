<?php


class TaskManager
{
    private array $tasks = [];
    private static int $nextId = 1;

    public function addTask(Task $task): void
    {

        if (!$task->getId() || $task->getId() === 0) {
            $task->setId(self::$nextId++);
            $this->tasks[] = $task;
        } else {
            foreach ($this->tasks as $t) {
                if ($t->getId() === $task->getId()) {
                    $t = $task;
                }
            }
        }
    }

    public function getAllTasks(): array
    {
        return $this->tasks;
    }

    public function getTaskById(int $id): ?Task
    {
        foreach ($this->tasks as $task) {
            if ($task->getId() === $id) {
                return $task;
            }
        }
        return null;
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->tasks as $task) {
            $array[] = $task->toArray();
        }

        return $array;

    }

    public function countTasks(): int
    {
        $total = COUNT($this->tasks);
        return $total;
    }

    public function getTasksByStatus(int $status): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if ($task->getStatus() === $status) {
                $tasks[] = $task;
            }
        }
        return $tasks;
    }
}

