<?php

declare(strict_types = 1);

namespace Telegram\Exception;

use Telegram\API\Base\Abstracts\ABaseObject;

class OutboundException extends \Exception {

    private ABaseObject $_originatingObject;
    private $_reply;

    public function __construct(ABaseObject $originatingObject, $reply, $message = "", $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->_originatingObject = $originatingObject;
        $this->_reply = $reply;
    }

    public function getOriginatingObject() : ABaseObject {
        return $this->_originatingObject;
    }

    public function getReply() {
        return $this->_reply;
    }
}
