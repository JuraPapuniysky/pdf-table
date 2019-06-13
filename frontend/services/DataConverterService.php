<?php

declare(strict_types=1);

namespace frontend\services;

use common\models\Data;

class DataConverterService
{
    public function getDataModels(string $text): array
    {
        $arrayText = explode(PHP_EOL, $text);

        $data = $this->getDatesPOPNRS($arrayText);

        $convertedData = [];
        foreach ($data[2] as $key => $item) {
            $arrayData = explode(' ', explode('Сторінка', $item)[0]);
            $dataModel = new Data();
            $dataModel->time = $data[0][$key];
            $dataModel->serviceType = $data[1][$key];
            if (count($arrayData) === 12) {
                $dataModel->direct = $this->getDirect($arrayData);
                $dataModel->countTime = $arrayData[2];
                $dataModel->phone = $arrayData[3];
                $dataModel->extraMinutes = $arrayData[4];
                $dataModel->cost = $arrayData[5];
                $dataModel->internationalRoamingCost = $arrayData[6];
                $dataModel->nationalRoamingCost = $arrayData[7];
                $dataModel->tariffZone = str_replace(PHP_EOL, ' ', $arrayData[8]);
                $dataModel->tariffTime = $this->getTariffTime($arrayData);

                array_push($convertedData, $dataModel);
            }

            if (count($arrayData) === 11) {
                $dataModel->direct = $this->getDirect($arrayData);
                $dataModel->countTime = $arrayData[2];
                $dataModel->phone = $arrayData[3];
                $dataModel->extraMinutes = '';
                $dataModel->cost = $arrayData[4];
                $dataModel->internationalRoamingCost = $arrayData[5];
                $dataModel->nationalRoamingCost = $arrayData[6];
                $dataModel->tariffZone = str_replace(PHP_EOL, ' ', $arrayData[7]);
                $dataModel->tariffTime = $arrayData[8] . ' ' . str_replace(PHP_EOL, ' ', $arrayData[9]) . $arrayData[10];

                array_push($convertedData, $dataModel);
            }

            if (count($arrayData) === 9) {
                $dataModel->direct = $this->getDirect($arrayData);
                $dataModel->countTime = $arrayData[2];
                $dataModel->phone = $arrayData[3];
                $dataModel->extraMinutes = '';
                $dataModel->cost = $arrayData[4];
                $dataModel->internationalRoamingCost = $arrayData[5];
                $dataModel->nationalRoamingCost = $arrayData[6];
                $dataModel->tariffZone = '';
                $dataModel->tariffTime = $arrayData[7] . ' ' . $arrayData[8];

                array_push($convertedData, $dataModel);
            }
        }

        return $convertedData;
        //return [$dates, $popNrs, $data];
    }

    public function createXlsFromDataModels(array $dataModels): array
    {
        return $dataModels;
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

    private function getDirect(array $item): string
    {
        return $item[0] . ' ' . $item[1];
    }

    private function getTariffTime(array $item): string
    {
        return $item[9] . ' ' . str_replace(PHP_EOL, ' ', $item[10]) . $item[11];
    }
}