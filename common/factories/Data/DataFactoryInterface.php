<?php

declare(strict_types=1);

namespace common\factories\Data;

use common\models\Data;

interface DataFactoryInterface
{
    public function getDataModel(array $data, string $item, int $key): Data;
}