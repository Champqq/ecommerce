<?php

declare(strict_types=1);

namespace App\Service\Entity;

interface EntityServiceInterface
{
    public function save(object $entity): void;

    public function delete(object $entity): void;

    public function markToSave(object $entity): void;

    public function markToDelete(object $entity): void;
}
