<?php

namespace Models;

use PDO;
use Services\Db;

abstract class ActiveRecordEntity
{
    protected ?int $id = null;

    public function getId() : int
    {
        return $this->id;
    }

    public static function getById(int $id)
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE id=:id;',
            [':id' => $id],
            static::class,
        );
        return $entities ? $entities[0] : null;
    }

    public static function findAll() : array
    {
        $db = Db::getInstance();
        return $db->query('select * from ' . static::getTableName() . ';', [], static::class);
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $columns2params[] = $column . ' = ' . $param;
            $params2values[$param] = $value;
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $mappedPropertiesNotNull = array_filter($mappedProperties);

        $columns = [];
        $params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedPropertiesNotNull as $column => $value) {
            $params[] = ':param' . $index;
            $columns[] = $column;
            $params2values[':param' . $index] = $value;
            $index++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . '(' . implode(', ', $columns) . ')' . ' VALUES (' . implode(', ', $params) . ' )';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);

        $this->id = $db->getLastInsertId();
        $this->refresh();
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query(
            'DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    public function __set($name, $value) : void
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    abstract protected static function getTableName() : string;

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $tableName = static::getTableName();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $columnName . ' = :field LIMIT 1';
        $result = $db->query($sql, [$value], static::class);
        if ($result === []) {
            return null;
        }


        return $result[0];
    }
}