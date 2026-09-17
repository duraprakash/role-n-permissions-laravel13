<?php

namespace App\Enums;

enum Role: int
{
    case User = 1;
    case Administrator = 2;
    case Manager = 3;
}
