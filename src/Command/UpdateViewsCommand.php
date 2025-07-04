<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\ProductRepository;
use App\Service\Entity\EntityServiceInterface;
use Redis;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:sync-product-views',)]
class UpdateViewsCommand extends Command
{
    public function __construct(
        private Redis $redis,
        private ProductRepository $productRepository,
        private EntityServiceInterface $entityService,
        private string $keyPrefix,
    ) {
        parent::__construct();
    }

    /**
     * @throws \RedisException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $productIds = $this->redis->keys($this->keyPrefix . '*');

        foreach ($productIds as $key) {
            $id = (int)str_replace($this->keyPrefix, '', $key);
            $views = (int)$this->redis->get($key);

            $product = $this->productRepository->find($id);

            if ($product && $views > 0) {
                $product->updateViews($views);

                $this->entityService->save($product);

                $this->redis->del($key);
            }
        }

        return Command::SUCCESS;
    }
}
