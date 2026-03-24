<?php

namespace App\Enums;

enum ActionStatus: string
{
    case Active = 'active';
    case Edited = 'edited';
    case Finished = 'finished';
    case Cancelled = 'canceled'; // ⬅️ MUDAR para 'canceled' (com 1 L)
}
