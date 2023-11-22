<?php

namespace App\Enums;

enum EvaluateEyeOpening: int
{
    // case 1 = '1';
    // case Active = '2';
    // case Inactive = '3';
    // case Rejected = '4';

    case INITIATED = 1;
    case SUCCESS = 2;
    case DECLINED = 3;
    case DECLINED23 = 4;

}
