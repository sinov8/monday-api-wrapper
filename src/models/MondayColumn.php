<?php

namespace sinov8\MondayApiWrapper\models;

class MondayColumn
{

    const TYPE_TEXT = "text";
    const TYPE_NUMERIC = "numeric";
    const TYPE_DATE = "date";

    private $id;
    private $type;
    private $value;

    public function __construct($id, $type, $value)
    {
        $this->id = $id;
        $this->type = $type;
        $this->value = $value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->id;
    }

    public function getValue()
    {

        switch ($this->type) {

            case self::TYPE_TEXT:
            case self::TYPE_NUMERIC:
                return (string)$this->value;

            case self::TYPE_DATE:
                if ($this->value) {
                    return ['date' => $this->value->format('Y-m-d')];
                }
                return null;

        }

        return null;

    }


}