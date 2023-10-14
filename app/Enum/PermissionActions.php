<?php declare(strict_types=1);

namespace App\Enum;

enum PermissionActions: string
{
    case CREATE = 'Create';
    case UPDATE = 'Update';
    case DELETE = 'Delete';
    case FORCE_DELETE = 'ForceDelete';
    case RESTORE = 'Restore';
}
