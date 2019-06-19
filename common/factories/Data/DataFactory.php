<?php

declare(strict_types=1);

namespace common\factories\Data;

use common\models\Data;
use function PHPSTORM_META\elementType;

class DataFactory implements DataFactoryInterface
{

    const DATA_IN = 9;

    public function getDataModel(array $data, string $item, int $key): Data
    {
        $arrayData = explode(' ', explode('Сторінка', $item)[0]);
        $dataModel = new Data();
        $dataModel->serviceType = $data[1][$key];
        $dataModel->time = $data[0][$key];

        if (count($arrayData) === self::DATA_IN) {
            return $this->getDataIn($arrayData, $dataModel);
        } else {
            return $this->getDataSimple($arrayData, $dataModel);
        }
    }

    private function getDataSimple(array $arrayData, Data $dataModel): Data
    {
        $dataModel->direct = $this->getDirect($arrayData);
        $dataModel->bits = $this->convertToKb($arrayData[2] , $arrayData[3]);
        $dataModel->phone = $arrayData[4];
        $dataModel->extraTime = '';
        $dataModel->cost = $this->convertStringToFloat($arrayData[5]);
        $dataModel->internationalRoamingCost = $this->convertStringToFloat($arrayData[6]);
        $dataModel->nationalRoamingCost = $this->convertStringToFloat($arrayData[7]);
        $dataModel->tariffZone = str_replace(PHP_EOL, ' ', $arrayData[8] . ' ' . $arrayData[9]);
        $dataModel->tariffTime = str_replace(PHP_EOL, ' ', $arrayData[10] . $arrayData[11] . $arrayData[12]);
        if (isset($arrayData[13]) && isset($arrayData[14])) {
            $dataModel->tariffGroup = $arrayData[13] . $arrayData[14];
        } else {
            $dataModel->tariffGroup = '';
        }

        return $dataModel;
    }

    private function getDataIn(array $arrayData, Data $dataModel): Data
    {
        $dataModel->direct = $this->getDirect($arrayData);
        $dataModel->bits = $arrayData[2];
        $dataModel->phone = $arrayData[3];
        $dataModel->extraTime = 0;
        $dataModel->cost = $this->convertStringToFloat($arrayData[4]);;
        $dataModel->internationalRoamingCost = $this->convertStringToFloat($arrayData[5]);;
        $dataModel->nationalRoamingCost = $this->convertStringToFloat($arrayData[6]);;
        $dataModel->tariffZone = '';
        $dataModel->tariffTime = $arrayData[7] . ' ' . $arrayData[8];
        $dataModel->tariffGroup = '';

        return $dataModel;
    }

    private function getDirect(array $item): string
    {
        return $item[0] . ' ' . $item[1];
    }

    private function convertStringToFloat($string): float
    {
        return (float)str_replace(',', '.', $string);
    }

    private function convertToKb(string $value, string $dimension): float
    {
        if ($dimension === 'Mb') {
            return round($value * 1024);
        } elseif ($dimension === 'Kb') {
            return (float) $value;
        } elseif ($dimension === 'b') {
            return $value / 1024;
        } else {
            return 0;
        }
    }
}