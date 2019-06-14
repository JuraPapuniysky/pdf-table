<?php

declare(strict_types=1);

namespace common\factories\Data;

use common\models\DataTime;

class DataFactory implements DataFactoryInterface
{

    public function getDataModel(array $data, string $item, int $key): DataTime
    {
        // TODO: Implement getDataModel() method.
    }
}