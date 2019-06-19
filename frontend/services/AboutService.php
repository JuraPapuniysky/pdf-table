<?php

declare(strict_types=1);

namespace frontend\services;


use common\factories\AboutForm\AboutFormFactory;
use frontend\models\AboutForm;

class AboutService
{
    const TIME_REPORT_PATH = __DIR__ . '/../../test-files/time-repost-example.txt';
    const DATA_REPORT_PATH = __DIR__ . '/../../test-files/data-repost-example.txt';

    /**
     * @var AboutFormFactory $aboutFormFactory
     */
    private $aboutFormFactory;

    public function __construct(AboutFormFactory $aboutFormFactory)
    {
        $this->aboutFormFactory = $aboutFormFactory;
    }

    public function getAboutData(): AboutForm
    {
        return $this->aboutFormFactory->getAboutForm(self::DATA_REPORT_PATH, self::TIME_REPORT_PATH);
    }
}