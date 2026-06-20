<?php

namespace App\Filters\v1\accounts;

use App\Filters\v1\ApiFilter;

class BusinessFilter extends ApiFilter
{
    // eq->Equal To, gt->Greater Than , lt-> Less Than

    protected $safeParams = [
        'business_name' => ['eq', 'ne'],
        'contact' => ['eq', 'ne'],
        'email' => ['eq', 'ne'],
        'location' => ['eq', 'ne'],
        'isActive' => ['eq', 'ne'],
    ];

    // API uses different naming than the database
    protected $columnMap = [
        'businessName' => 'business_name',
        'isActive' => 'is_active',
    ];
}
