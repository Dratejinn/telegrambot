<?php

declare(strict_types = 1);

namespace Examples\Bot\Handlers;

use Telegram\Bot\Handler\AInlineQueryHandler;
use Telegram\API\InlineQuery;

class InlineQueryHandler extends AInlineQueryHandler {

    public function handle() {

        $answer = $this->createAnswer();

        $photoAnswer = new InlineQuery\InlineQueryResultPhoto;
        $photoAnswer->id = self::GenerateId();
        $photoAnswer->title = 'someImage1';
        $photoAnswer->photoUrl = 'http://cdn.hotkiss.nl/webshop/producten/swimwear/monokini/LC40381/sexy-witte-monokini-2.jpg';
        $photoAnswer->thumbUrl = 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQA_puj9-SdeeXbFxPm5LCJL2lYz73eS2-LbGIcnS-qnPHilQRgAQ';

        $photoAnswer2 = new InlineQuery\InlineQueryResultPhoto;
        $photoAnswer2->id = self::GenerateId();
        $photoAnswer2->title = 'someImage2';
        $photoAnswer2->photoUrl = 'http://static.webshopapp.com/shops/065789/files/030830268/soleil-fashion-sexy-broekje.jpg';
        $photoAnswer2->thumbUrl = 'http://static.webshopapp.com/shops/065789/files/030830268/156x164x1/soleil-fashion-sexy-broekje.jpg';
        $answer->results = [$photoAnswer, $photoAnswer2];
        $answer->call($this->_apiBot);
    }
}
