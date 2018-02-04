<?php

declare(strict_types = 1);

#if (${NAMESPACE})
namespace ${NAMESPACE};

#end
use Telegram\API\Base\Abstracts\ABaseObject;

class ${NAME} extends ABaseObject {

    /**
     * @inheritdoc
     */
    public static function GetDatamodel() : array {
        ${DS}datamodel = [
        ];
        return array_merge(parent::GetDatamodel(), ${DS}datamodel);
    }
}