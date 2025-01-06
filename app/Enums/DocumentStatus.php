<?php

namespace App\Enums;

enum DocumentStatus: string
{
    case DRAFT = 'draft';
    case SUBMIT = 'submit';
    case ON_REVIEW = 'on review';
    case ON_CONFIRMATION = 'on confirmation';
    case APPROVAL = 'approval';
    case APPROVED = 'approved';
    case REVISED = 'revised';
    case DELETED = 'deleted';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ON_REVIEW => 'On Review',
            self::ON_CONFIRMATION => 'On Confirmation',
            self::APPROVAL => 'Approval',
            self::APPROVED => 'Approved',
            self::REVISED => 'Revised',
            self::DELETED => 'Deleted',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'light',
            self::ON_REVIEW => 'secondary',
            self::ON_CONFIRMATION => 'info',
            self::APPROVAL => 'primary',
            self::APPROVED => 'success',
            self::REVISED => 'warning',
            self::DELETED => 'danger',
        };
    }
}
