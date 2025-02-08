<?php

namespace App\Enums;

/**
 * Перечисление возможных видов деятельности Организации
 */
enum ActivityCategory: string
{
    case MEAT = 'Мясное';
    case MILK = 'Молочное';
    case MEAT_MILK = 'Мясо-молочное';
}
