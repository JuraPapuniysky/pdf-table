<?php

declare(strict_types=1);

namespace common\factories\Spreadsheet;


use yii2tech\spreadsheet\Spreadsheet;

interface SpreadsheetInterface
{
    public function getSpreadsheet(array $dataModels): Spreadsheet;
}