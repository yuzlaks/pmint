<?php

namespace App\Core;

class PcodeMigration
{
    public $table = "";
    public $command = [];
    public $column = "";

    // CREATE TABLE
    function table($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    function addColumn($columnName, $dataType)
    {
        $this->column = $columnName;
        $this->command[] = "`" . $columnName . "` " . $dataType . " NOT NULL";
        return $this;
    }

    function nullable()
    {
        $this->command[$this->lastNum('command')] = $this->lastData('command') . " NULL";

        $this->command[$this->lastNum('command')] = str_replace("NOT NULL NULL", "NULL", $this->command[$this->lastNum('command')]);

        return $this;
    }

    function ai()
    {
        $this->command[$this->lastNum('command')] = $this->lastData('command') . " AUTO_INCREMENT, PRIMARY KEY (`" . $this->column . "`)";
        return $this;
    }

    function primary()
    {
        $this->command[$this->lastNum('command')] = $this->lastData('command') . " , PRIMARY KEY (`" . $this->column . "`)";
        return $this;
    }

    function
    default($defaultType)
    {
        $this->command[$this->lastNum('command')] = $this->lastData('command') . " DEFAULT $defaultType";
        return $this;
    }

    function create()
    {
        $command = implode(",", $this->command);
        $this->command = "CREATE TABLE `" . $this->table . "` ($command);";
        return $this->command;
    }
    // END CREATE

    // ALTER
    function alterColumn($columnName, $dataType)
    {
        $this->column = $columnName;
        $this->command[] = "MODIFY COLUMN `" . $columnName . "` " . $dataType;
        return $this;
    }

    function alterChangeColumn($columnName, $toColumnName, $dataType)
    {
        $this->column = $columnName;
        $this->command[] = "CHANGE `" . $columnName . "` `" . $toColumnName . "` " . $dataType;
        return $this;
    }

    function alterAddColumn($columnName, $dataType)
    {
        $this->column = $columnName;
        $this->command[] = "ADD `" . $columnName . "` " . $dataType;
        return $this;
    }

    function alterDropColumn($columnName)
    {
        $this->column = $columnName;
        $this->command[] = "DROP COLUMN `" . $columnName . "`";
        return $this;
    }

    function alter()
    {
        $command = implode(",", $this->command);
        $this->command = "ALTER TABLE `" . $this->table . "` $command;";
        return $this->command;
    }

    // END ALTER

    // DROP
    function drop()
    {
        $this->command = "DROP TABLE `" . $this->table . "`";
        return $this->command;
    }
    function truncate()
    {
        $this->command = "TRUNCATE TABLE `" . $this->table . "`";
        return $this->command;
    }
    // END DROP



    // ADDITIONAL
    function lastNum($data)
    {
        return count($this->{$data}) - 1;
    }

    function lastData($data)
    {
        return $this->{$data}[$this->lastNum($data)];
    }
    // END ADDITIONAL
}
