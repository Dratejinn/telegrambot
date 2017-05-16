<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

use Telegram\API\Base\Abstracts\ABaseObject;

interface ITelegramStorageHandler {
    public function getStorageHandlerName() : string;
    public function store(ABaseObject $object) : bool;
    public function delete(ABaseObject $object) : bool;
    public function load(string $id, string $index) : ABaseObject;
}
