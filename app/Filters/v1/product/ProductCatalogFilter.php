<?php

namespace App\Filters\v1\product;

use App\Filters\v1\ApiFilter;

class ProductCatalogFilter extends ApiFilter
{
    protected $safeParams = [
        'product_id'   => ['eq', 'ne'],
        'name'         => ['eq', 'ne', 'like'],
        'category_id'  => ['eq', 'ne'],
        'brand'        => ['eq', 'ne', 'like'],
        'description'  => ['eq', 'ne', 'like'],
        'image_url'    => ['eq', 'ne'],
        'business_id'   => ['eq', 'ne'],
        'branch_id'     => ['eq', 'ne'],
        'is_available' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'businessId' => 'business_id',
        'branchId'   => 'branch_id',
        'productId' => 'product_id',
        'categoryId'   => 'category_id',
        'imageUrl' => 'image_url',
        'isAvailable'   => 'is_available',
    ];
}