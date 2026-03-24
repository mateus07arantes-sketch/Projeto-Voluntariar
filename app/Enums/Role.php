<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Ong = 'ong';
    case User = 'user';
}
