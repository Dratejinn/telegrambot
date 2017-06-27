<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

use Telegram\API\Base\Abstracts\ABaseObject;

interface ITelegramStorageHandler {
    public function getStorageHandlerName() : string;
    public function store(ABaseObject $object, array $optionalArguments = []) : bool;
    public function delete(ABaseObject $object) : bool;
    public function load(string $class, string $id = '', string $index = NULL, array $optionalArguments = []) : ABaseObject;
    public function loadAll(string $class, string $index = NULL, array $optionalArguments = []) : array;
}
