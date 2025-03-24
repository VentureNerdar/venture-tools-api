<?php

namespace App\Enums;

enum ResponseType: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case FILE = 'file;';
}
