<?php

declare(strict_types=1);

namespace common\factories\Spreadsheet;


use yii\data\ArrayDataProvider;
use yii2tech\spreadsheet\Spreadsheet;

class SpreadsheetFactory implements SpreadsheetInterface
{

    public function getSpreadsheet(array $dataModels): Spreadsheet
    {
        $exporter = new Spreadsheet([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $dataModels
            ])
        ]);

        return $exporter;
    }
}