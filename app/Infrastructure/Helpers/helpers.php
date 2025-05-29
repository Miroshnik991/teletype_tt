<?php

/**
 * Возвращает ассоциативный массив всех свойств объекта через геттеры.
 *
 * @param object $object Объект, геттеры которого нужно вызвать
 * @return array Ассоциативный массив [propertyName => value]
 */
function getObjectPropertiesViaGetters(object $object): array
{
    $reflection = new ReflectionClass($object);
    $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
    $properties = [];

    foreach ($methods as $method) {
        if (preg_match('/^(get|is)(.+)$/', $method->name, $matches)) {
            $propertyName = lcfirst($matches[2]);

            try {
                $value = $method->invoke($object);
                $properties[$propertyName] = $value;
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    return $properties;
}
