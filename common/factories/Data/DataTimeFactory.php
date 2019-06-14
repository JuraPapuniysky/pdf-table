<?php

declare(strict_types=1);

namespace common\factories\Data;

use common\models\DataTime;

class DataTimeFactory implements DataFactoryInterface
{

    const DATA = 11;
    const DATA_WITH_EXTRA_MIN = 12;
    const DATA_IN = 9;

    public function getDataModel(array $data, string $item, int $key): DataTime
    {
        $arrayData = explode(' ', explode('Сторінка', $item)[0]);
        $dataModel = new DataTime();
        $dataModel->time = $data[0][$key];
        $dataModel->serviceType = $data[1][$key];

        if (count($arrayData) === self::DATA) {
            return $this->getDataSimple($arrayData, $dataModel);
        } elseif (count($arrayData) === self::DATA_WITH_EXTRA_MIN) {
            return $this->getDataWithExtraMinutes($arrayData, $dataModel);
        } elseif (count($arrayData) === self::DATA_IN) {
            return $this->getDataIn($arrayData, $dataModel);
        }
    }

    private function getDataSimple(array $arrayData, DataTime $dataModel): DataTime
    {
        $dataModel->direct = $this->getDirect($arrayData);
        $dataModel->countTime = $this->convertCountTimeToSeconds($arrayData[2]);
        $dataModel->phone = $arrayData[3];
        $dataModel->extraMinutes = $this->convertCountTimeToSeconds('');
        $dataModel->cost = $this->convertStringToFloat($arrayData[4]);
        $dataModel->internationalRoamingCost = $this->convertStringToFloat($arrayData[5]);
        $dataModel->nationalRoamingCost = $this->convertStringToFloat($arrayData[6]);
        $dataModel->tariffZone = str_replace(PHP_EOL, ' ', $arrayData[7]);
        $dataModel->tariffTime = $arrayData[8] . ' ' . str_replace(PHP_EOL, ' ', $arrayData[9]) . $arrayData[10];

        return $dataModel;
    }

    private function getDataWithExtraMinutes(array $arrayData, DataTime $dataModel): DataTime
    {
        $dataModel->direct = $this->getDirect($arrayData);
        $dataModel->countTime = $this->convertCountTimeToSeconds($arrayData[2]);
        $dataModel->phone = $arrayData[3];
        $dataModel->extraMinutes = $this->convertCountTimeToSeconds($arrayData[4]);
        $dataModel->cost = $this->convertStringToFloat($arrayData[5]);
        $dataModel->internationalRoamingCost = $this->convertStringToFloat($arrayData[6]);
        $dataModel->nationalRoamingCost = $this->convertStringToFloat($arrayData[7]);
        $dataModel->tariffZone = str_replace(PHP_EOL, ' ', $arrayData[8]);
        $dataModel->tariffTime = $this->getTariffTime($arrayData);

        return $dataModel;
    }

    private function getDataIn(array $arrayData, DataTime $dataModel): DataTime
    {
        $dataModel->direct = $this->getDirect($arrayData);
        $dataModel->countTime = $this->convertCountTimeToSeconds($arrayData[2]);
        $dataModel->phone = $arrayData[3];
        $dataModel->extraMinutes = 0;
        $dataModel->cost = $this->convertStringToFloat($arrayData[4]);;
        $dataModel->internationalRoamingCost = $this->convertStringToFloat($arrayData[5]);;
        $dataModel->nationalRoamingCost = $this->convertStringToFloat($arrayData[6]);;
        $dataModel->tariffZone = '';
        $dataModel->tariffTime = $arrayData[7] . ' ' . $arrayData[8];

        return $dataModel;
    }

    private function getDirect(array $item): string
    {
        return $item[0] . ' ' . $item[1];
    }

    private function getTariffTime(array $item): string
    {
        return $item[9] . ' ' . str_replace(PHP_EOL, ' ', $item[10]) . $item[11];
    }

    private function convertCountTimeToSeconds($time): int
    {
        $subs = explode(':', $time);
        if (isset($subs[0]) && isset($subs[1])) {
            return $subs[0] * 60 + $subs[1];
        }

        return 0;
    }

    private function convertStringToFloat($string): float
    {
        return (float)str_replace(',', '.', $string);
    }
}