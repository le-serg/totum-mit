<?php


namespace totum\fieldTypes;

use totum\common\NoValueField;
use totum\common\Calculate;
use totum\tableTypes\aTable;

class Chart extends NoValueField
{
    /**
     * @var Calculate
     */
    protected $chartFormat;

    protected function __construct($fieldData, aTable $table)
    {
        parent::__construct($fieldData, $table);

        if (!empty($this->data['codeChart']) && $this->data['codeChart'] != '=:') {
            $this->chartFormat = new Calculate($this->data['codeChart']);
        }
    }

    public function modify($channel, $changeFlag, $newVal, $oldRow, $row = [], $oldTbl = [], $tbl = [], $isCheck = false)
    {
        return ["v" => null];
    }

    public function add($channel, $inNewVal, $row = [], $oldTbl = [], $tbl = [], $isCheck = false, $vars = [])
    {
        return ["v" => null];
    }

    function addFormat(&$valArray, $row, $tbl)
    {
        parent::addFormat($valArray, $row, $tbl);
        if ($this->chartFormat) {
            if ($format = $this->chartFormat->exec($this->data, [], $row, $row, $tbl, $tbl, $this->table, [])) {
                $valArray['ch'] = $format;
            }
            $this->addInControllerLog('f',
                ["text" => "Формирование графика", "children" => [$this->chartFormat->getLogVar()]],
                $row);
        }
    }
}