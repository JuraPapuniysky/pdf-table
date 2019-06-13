<?php

declare(strict_types=1);

namespace common\models;

use yii\base\Model;

/**
 * @property string $time
 * @property string $serviceType
 * @property string $direct
 * @property string $countTime
 * @property string $phone
 * @property string $extraMinutes
 * @property string $cost
 * @property string $internationalRoamingCost
 * @property string $nationalRoamingCost
 * @property string $tariffZone
 * @property string $tariffTime
 * @property string $tariffGroup
 */
class Data extends Model
{
    public $time;
    public $serviceType;
    public $direct;
    public $countTime;
    public $phone;
    public $extraMinutes;
    public $cost;
    public $internationalRoamingCost;
    public $nationalRoamingCost;
    public $tariffZone;
    public $tariffTime;
    public $tariffGroup;

    public function rules(): array
    {
        return [
            [
                [
                    'time',
                    'serviceType',
                    'direct',
                    'countTime',
                    'phone',
                    'extraMinutes',
                    'cost',
                    'internationalRoamingCost',
                    'nationalRoamingCost',
                    'tariffZone',
                    'tariffTime',
                    'tariffGroup',
                ],
                'string'
            ],
        ];
    }
}