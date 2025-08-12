<?php

declare(strict_types=1);

namespace App\Service\Product\Views;

use Redis;
use RedisException;

class ProductViewsService implements ProductViewsServiceInterface
{
    public function __construct(
        private Redis $redis,
        private string $keyPrefix,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function incrementViews(int $productId): void
    {
        $this->redis->incr($this->keyPrefix . $productId);
    }
}
