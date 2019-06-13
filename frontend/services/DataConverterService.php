<?php

declare(strict_types=1);

namespace frontend\services;

use common\factories\Data\DataFactory;
use common\factories\Spreadsheet\SpreadsheetFactory;
use yii2tech\spreadsheet\Spreadsheet;

class DataConverterService
{
    /**
     * @var DataFactory $dataFactory
     */
    private $dataFactory;

    /**
     * @var SpreadsheetFactory
     */
    private $spreadSheetFactory;

    public function __construct(DataFactory $dataFactory, SpreadsheetFactory $spreadsheetFactory)
    {
        $this->dataFactory = $dataFactory;
        $this->spreadSheetFactory = $spreadsheetFactory;
    }

    public function getDataModels(string $text): array
    {
        $arrayText = explode(PHP_EOL, $text);

        $data = $this->getDatesPOPNRS($arrayText);

        $convertedData = [];
        foreach ($data[2] as $key => $item) {
            array_push($convertedData, $this->dataFactory->getDataModel($data, $item, $key));
        }

        return $convertedData;
    }

    public function createXlsExporterFromDataModels(array $dataModels): Spreadsheet
    {
        return $this->spreadSheetFactory->getSpreadsheet($dataModels);
    }

    private function getDatesPOPNRS(array $arrayText): array
    {
        $dates = [];
        $popNrs = [];
        $data = [];
        for ($i = 0; $i < count($arrayText); $i++) {
            if (\DateTime::createFromFormat('d.m.Y H:i:s', trim($arrayText[$i])) !== false) {
                array_push($dates, $arrayText[$i]);
            }

            if (strstr(trim($arrayText[$i]), 'POP') !== false) {
                array_push($popNrs,
                    $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3] . $arrayText[$i + 4]);
            }

            if (strstr(trim($arrayText[$i]), 'Вхідне') !== false) {
                array_push($popNrs, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3]);
            }

            if (strstr(trim($arrayText[$i]), 'Вих.') !== false) {
                array_push($data, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2]);
            }

            if (strstr(trim($arrayText[$i]), 'Вх.') !== false) {
                array_push($data, $arrayText[$i]);
            }
        }

        return [$dates, $popNrs, $data];
    }

}