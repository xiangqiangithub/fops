<?php
namespace fop\Http\Response;
use fop\Util\StringUtil;

    class XmlAdapter extends AbstractResponse {

    public function toArray(): array
    {
        //解密 todo
        StringUtil::stripNonValidXMLCharacters($this->getBody()->getContents());
        return [];
    }
}
