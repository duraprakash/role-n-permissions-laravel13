<?php

namespace App\Enums;

enum Role: string
{
    case User = 'User';
    case Administrator = 'Administrator';
    case Manager = 'Manager';
}
