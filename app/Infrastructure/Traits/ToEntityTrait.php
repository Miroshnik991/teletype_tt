<?php

declare(strict_types=1);

namespace App\Infrastructure\Traits;

use DateTimeImmutable;
use ReflectionClass;
use ReflectionParameter;

trait ToEntityTrait
{
    /**
     * Преобразует модель в сущность Domain-слоя через рефлексию
     *
     * @return object Новая сущность
     * @throws \RuntimeException
     */
    public function toEntity(): object
    {
        try {
            $modelClass = get_class($this);
            $entityClass = str_replace(
                ['App\Infrastructure\Models\\', 'App\Domain\Models\\'],
                'App\Domain\Entities\\',
                $modelClass
            );

            if (!class_exists($entityClass)) {
                throw new \RuntimeException("Entity class {$entityClass} not found");
            }

            $reflection = new ReflectionClass($entityClass);
            $constructor = $reflection->getConstructor();

            if (!$constructor) {
                return $reflection->newInstance();
            }

            $args = [];
            foreach ($constructor->getParameters() as $param) {
                $args[] = $this->resolveParameter($param);
            }

            return $reflection->newInstanceArgs($args);
        } catch (\ReflectionException $e) {
            throw new \RuntimeException("Entity conversion failed: " . $e->getMessage());
        }
    }

    /**
     * Разрешает параметр конструктора сущности
     */
    private function resolveParameter(ReflectionParameter $param): mixed
    {
        $name = $param->getName();
        $type = $param->getType();

        if (property_exists($this, $name) || isset($this->$name)) {
            $value = $this->$name;

            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();

                if ($typeName === DateTimeImmutable::class && $value) {
                    return new DateTimeImmutable($value);
                }

                if (enum_exists($typeName) && $value) {
                    return $typeName::from($value);
                }

                if (str_starts_with($typeName, 'App\Domain\Entities\\')) {
                    return $value->toEntity();
                }
            }

            return $value;
        }

        if ($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        throw new \RuntimeException("Cannot resolve parameter {$name} for entity construction");
    }
}
