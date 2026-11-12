<?php

declare(strict_types=1);

namespace Lines\Skeleton\Core\Ordering\Application\Listeners;

use Lines\Skeleton\Core\Ordering\Domain\Events\OrderPlaced;

final class SendReceiptListener
{
    public function handle(OrderPlaced $event): void {}
}
