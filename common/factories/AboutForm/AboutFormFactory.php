<?php

declare(strict_types=1);

namespace common\factories\AboutForm;

use frontend\models\AboutForm;

class AboutFormFactory implements AboutFormFactoryInterface
{

    public function getAboutForm(string $dataPath, string $timePath): AboutForm
    {
        $about = new AboutForm();

        if (file_exists($dataPath)  && is_readable($dataPath)) {
            $about->data = file_get_contents($dataPath);
        }

        if (file_exists($timePath) && is_readable($timePath)) {
            $about->time = file_get_contents($timePath);
        }

        return $about;
    }
}