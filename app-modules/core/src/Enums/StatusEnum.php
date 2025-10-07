<?php

namespace Modules\Core\Enums;

enum StatusEnum: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PENDING = 'pending';

    public function toString(): ?string
    {
        return match ($this) {
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::PENDING => 'Pending',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::APPROVED => 'success',
            self::REJECTED => 'red',
            self::PENDING => 'gray',
        };
    }
}
