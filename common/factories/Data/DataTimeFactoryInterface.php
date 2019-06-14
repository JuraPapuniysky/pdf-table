<?php

declare(strict_types=1);

namespace common\factories\Data;

use common\models\DataTime;

interface DataTimeFactoryInterface
{
    public function getDataModel(array $data, string $item, int $key): DataTime;
}