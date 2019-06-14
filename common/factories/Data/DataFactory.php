<?php

declare(strict_types=1);

namespace common\factories\Data;

use common\models\Data;

class DataFactory implements DataFactoryInterface
{

    public function getDataModel(array $data, string $item, int $key): Data
    {
        // TODO: Implement getDataModel() method.
    }



    private function getDataIn(array $arrayData, Data $dataModel): Data
    {
        $dataModel->direct = $this->getDirect($arrayData);
        $dataModel->bits = $arrayData[2];
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
}