<?php

declare(strict_types=1);

namespace App\Service\Product;

use Redis;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private Redis $redis,
        private string $keyPrefix,
    ) {
    }

    /**
     * @throws \RedisException
     */
    public function incrementViews(int $productId): void
    {
        $this->redis->incr($this->keyPrefix . $productId);
    }
}
