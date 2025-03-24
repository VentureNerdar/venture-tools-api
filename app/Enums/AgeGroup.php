<?php

namespace App\Enums;

enum AgeGroup: string
{
    case UNDER_EIGHTEEN_YEARS_OLD = 'Under 18 years old';
    case EIGHTEEN_TWENTY_FIVE_YEARS_OLD = '18-25 years old';
    case TWENTY_SIX_FORTY_YEARS_OLD = '26-40 years old';
    case OVER_FORTY_YEARS_OLD = 'Over 40 years old';

    public static function values(): array
    {
        return array_column(AgeGroup::cases(), 'value');
    }
}
