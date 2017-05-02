<?php

declare(strict_types = 1);

namespace Telegram\LogHelpers;

use Monolog\Logger;

class ChannelLengthProcessor {

    protected $_length = 10;

    public function __construct(int $length = 10) {
        $this->_length = $length;
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record) {
        $channelLength = strlen($record['channel']);
        if ($channelLength >= $this->_length) {
            $record['channel'] = substr($record['channel'], 0, $this->_length);
        } else {
            for ($i = $channelLength; $i < $this->_length ; $i++) {
                $record['channel'] .= ' ';
            }
        }
        return $record;
    }
}
