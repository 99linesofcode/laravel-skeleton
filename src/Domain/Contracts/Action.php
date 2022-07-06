<?php declare(strict_types=1);

namespace Domain\Contracts;

interface Action
{
    public function execute() : void;
}
