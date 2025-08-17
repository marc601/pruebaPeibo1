<?php

declare(strict_types=1);

class Task
{
    private ?int $id = null;
    private ?string $title = null;
    private string $description;
    private ?int $status = null;

    public const STATUS_PENDING = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_DONE = 3;

    public static array $statuses = [
        self::STATUS_PENDING => 'Pendiente',
        self::STATUS_IN_PROGRESS => 'En progreso',
        self::STATUS_DONE => 'Realizado',
    ];

    public function __toString(): string
    {
        $id = $this->id ?? 'No definido';
        return 'Id: ' . $id . ' Titulo: ' . $this->title . ' Descripcion: ' . $this->description . ' Estatus: ' . $this->getStatusString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->validateStatus($status);
        $this->status = $status;
    }

    protected function validateStatus(?int $status): void
    {
        if ($status === null) {
            throw new Exception('Indique almenos un estatus');
        }
        if (!in_array($status, array_keys(self::$statuses))) {
            throw new Exception('El estatus : ' . $status . ' es invalido');
        }
    }

    public function markInProgress(): void
    {
        $this->setStatus(self::STATUS_IN_PROGRESS);
    }

    public function markDone(): void
    {
        $this->setStatus(self::STATUS_DONE);
    }

    public function getStatusString(): string
    {
        if ($this->getStatus() === null) {
            return '';
        }
        $this->validateStatus($this->getStatus());
        return self::$statuses[$this->getStatus()];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }

    public static function fromArray(array $data): self
    {
        $task = new self();
        $task->setId($data['id'] ?? 0);
        $task->setTitle($data['title'] ?? null);
        $task->setDescription($data['description'] ?? '');
        $task->setStatus($data['status'] ?? self::STATUS_PENDING);
        return $task;
    }
}
