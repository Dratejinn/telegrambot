<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

/**
 * Describes a storage service aware instance.
 */
interface IStorageHandlerAware {
    public function hasStorageService() : bool;
    public function getStorageService() : array;
    public function addStorageService(ITelegramStorageService $storageService);
}
