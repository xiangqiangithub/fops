<?php
namespace fop\Http\Response;
use fop\Out\FopOutUtil;
use Exception;

class JsonAdapter extends AbstractResponse {
    /**
     * @throws Exception
     */
    public function toArray(): array
    {
       echo $content = $this->getBody()->getContents();
        \GuzzleHttp\json_decode($content, true);
        $decrypt = FopOutUtil::reqDec($content,$this->rsaPrivateKey);
        return \GuzzleHttp\json_decode($decrypt, true);
    }
}