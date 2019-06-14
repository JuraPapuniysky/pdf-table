<?php

declare(strict_types=1);

namespace frontend\services;

use common\factories\Data\DataTimeFactory;
use common\factories\Data\DataFactory;
use common\factories\Spreadsheet\SpreadsheetFactory;
use yii2tech\spreadsheet\Spreadsheet;

class DataConverterService
{

    const DATA_REPORT_TYPE = 'data';
    const TIME_REPORT_TYPE = 'time';

    /**
     * @var DataTimeFactory $dataFactory
     */
    private $dataTimeFactory;

    /**
     * @var DataTimeFactory $dataFactory
     */
    private $dataFactory;

    /**
     * @var SpreadsheetFactory
     */
    private $spreadSheetFactory;

    public function __construct(
        DataTimeFactory $dataTimeFactory,
        DataFactory $dataFactory,
        SpreadsheetFactory $spreadsheetFactory
    ) {
        $this->dataTimeFactory = $dataTimeFactory;
        $this->dataFactory = $dataFactory;
        $this->spreadSheetFactory = $spreadsheetFactory;
    }

    public function getDataTimeModels(string $text): array
    {
        $arrayText = explode(PHP_EOL, $text);

        $data = $this->getDatesPOPNRS($arrayText, self::TIME_REPORT_TYPE);

        $convertedData = [];
        foreach ($data[2] as $key => $item) {
            array_push($convertedData, $this->dataTimeFactory->getDataModel($data, $item, $key));
        }

        return $convertedData;
    }

    public function getDataModels(string $text): array
    {
        $arrayText = explode(PHP_EOL, $text);

        $data = $this->getDatesPOPNRS($arrayText, self::DATA_REPORT_TYPE);

        return $data;
    }

    public function createXlsExporterFromDataModels(array $dataModels): Spreadsheet
    {
        return $this->spreadSheetFactory->getSpreadsheet($dataModels);
    }

    private function getDatesPOPNRS(array $arrayText, $reportType): array
    {
        $dates = [];
        $popNrs = [];
        $data = [];
        for ($i = 0; $i < count($arrayText); $i++) {
            if (\DateTime::createFromFormat('d.m.Y H:i:s', trim($arrayText[$i])) !== false) {
                array_push($dates, $arrayText[$i]);
            }

            $string = null;
            if ($reportType === self::DATA_REPORT_TYPE) {
                $string = $this->getPOPDataReport($arrayText, $i);
            } elseif ($reportType === self::TIME_REPORT_TYPE) {
               $string = $this->getPOPTimeReport($arrayText, $i);
            }

            if ($string !== null) {
                array_push($popNrs, $string);
            }

            if (strstr(trim($arrayText[$i]), 'Вхідне') !== false) {
                if ($reportType === self::TIME_REPORT_TYPE) {
                    array_push($popNrs, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3]);
                } elseif ($reportType === self::DATA_REPORT_TYPE) {
                    array_push($popNrs, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2]);
                }
            }

            if (strstr(trim($arrayText[$i]), 'Вих.') !== false) {
                if ($reportType === self::TIME_REPORT_TYPE) {
                    array_push($data, $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2]);
                } elseif ($reportType === self::DATA_REPORT_TYPE) {
                    array_push($data, $arrayText[$i] . $arrayText[$i + 1]);
                }
            }

            if (strstr(trim($arrayText[$i]), 'Вх.') !== false) {
                array_push($data, explode(' ', $arrayText[$i]));
            }
        }

        return [$dates, $popNrs, $data];
    }

    private function getPOPTimeReport($arrayText, $i): ?string
    {
        if (strstr(trim($arrayText[$i]), 'POP') !== false) {
            return $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3] . $arrayText[$i + 4];
        }

        return null;
    }

    private function getPOPDataReport($arrayText, $i): ?string
    {
        if (strstr(trim($arrayText[$i]), 'POP') !== false) {
            return $arrayText[$i] . $arrayText[$i + 1] . $arrayText[$i + 2] . $arrayText[$i + 3];
        }

        return null;
    }

}