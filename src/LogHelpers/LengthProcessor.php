<?php

declare(strict_types = 1);

namespace Telegram\LogHelpers;

class LengthProcessor {

    protected $_adjustingRecords    = NULL;
    protected $_contextRecords      = NULL;
    protected $_extraRecords        = NULL;

    /**
     * LengthProcessor constructor.
     * @param array $adjustingRecords
     * @param array $contextRecords
     * @param array $extraRecords
     */
    public function __construct(array $adjustingRecords = [], array $contextRecords = [], array $extraRecords = []) {
        $this->_adjustingRecords = $adjustingRecords;
        $this->_contextRecords = $contextRecords;
        $this->_extraRecords = $extraRecords;
    }

    /**
     * Called from a monolog logger implementation
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record) {
        if (!empty($this->_adjustingRecords)) {
            $record = $this->_processArray($record, $this->_adjustingRecords);
        }
        if (isset($record['context']) && !empty($this->_contextRecords)) {
            $record['context'] = $this->_processArray($record['context'], $this->_contextRecords);
        }
        if (isset($record['extra']) && !empty($this->_extraRecords)) {
            $record['extra'] = $this->_processArray($record['extra'], $this->_extraRecords);
        }
        return $record;
    }

    /**
     * Processes a log record
     * @param array $process
     * @param array $contextArray
     * @return array
     */
    private function _processArray(array $process, array $contextArray) {
        foreach ($contextArray as $recordKey => $length) {
            if (isset($process[$recordKey]) && is_string($process[$recordKey])) {
                $curLength = strlen($process[$recordKey]);
                if ($curLength >= $length) {
                    $process[$recordKey] = substr($process[$recordKey], 0, $length);
                } else {
                    for ($i = $curLength; $i < $length; $i++) {
                        $process[$recordKey] .= ' ';
                    }
                }
            }
        }
        return $process;
    }
}
