<?php

namespace App\Enums;

enum Status: string {
    case ACTIVO = 'A';
    case INACTIVO = 'I';
    case TRASH = 'trash';
}