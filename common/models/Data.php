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

    public function attributeLabels()
    {
        return [
            'time' => 'Час',
            'serviceType' => 'Тип сервісу',
            'direct'=> 'Напрямок',
            'countTime' => 'Кількість Сек/Kb',
            'phone' => 'Номер телефону/APN',
            'extraMinutes' => 'Використано пакетних/додаткових хвилин/грн.',
            'cost' => 'Вартість (без ПДВ), грн.',
            'internationalRoamingCost' => 'Вартість послуг міжнародного роумінгу**, грн',
            'nationalRoamingCost' => 'Вартість послуг національного роумінгу, грн.',
            'tariffZone' => 'Тарифна зона',
            'tariffTime' => 'Тарифний час',
            'tariffGroup' => 'Тарифна група',
        ];
    }
}