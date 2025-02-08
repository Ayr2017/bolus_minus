<?php

namespace App\Enums;

enum EquipmentType: string
{
    case PARALLEL = 'парралель';
    case HERRINGBONE = 'елочка';
    case CAROUSEL = 'карусель';
    case ROBOT = 'робот';
    case MILK_PIPELINE = 'молокопровод';
}
