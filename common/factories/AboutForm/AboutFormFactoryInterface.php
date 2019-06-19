<?php

declare(strict_types=1);

namespace common\factories\AboutForm;

use frontend\models\AboutForm;

interface AboutFormFactoryInterface
{
    public function getAboutForm(string $dataPath, string $timePath): AboutForm;
}