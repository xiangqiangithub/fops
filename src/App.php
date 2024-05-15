<?php
    namespace fop;
    use fop\Crypt\TaiBaoBizDataCrypt;
    use fop\Http\ClientFactory;
    use fop\Http\Config;
    use fop\Http\HttpClient;
    use Doctrine\Common\Collections\ArrayCollection;
    use GuzzleHttp\Client;
    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\DependencyInjection\Reference;
    use Symfony\Component\HttpFoundation\Request;

    class App extends ContainerBuilder {
    public $config;
    public function __construct(array $config = [])
    {
        parent::__construct();
        $this->config = new ArrayCollection($config);
        $this->_registerHttpClient();
        $this->_registerCallback();
    }
    private function _registerHttpClient() {
        $this->register('taibao_config', Config::class)
            ->addMethodCall('setAppId', [$this->config->get('app_id')])
            ->addMethodCall('setAppCode', [$this->config->get('app_code')])
            ->addMethodCall('setCharset', [$this->config->get('charset')])
            ->addMethodCall('setCipher', [$this->config->get('cipher')])
            ->addMethodCall('setFormat', [$this->config->get('format')])
            ->addMethodCall('setRsaPublicKey', [$this->opensslPublicKey()])
            ->addMethodCall('setRsaPrivateKey', [$this->opensslPrivateKey()])
            ->addMethodCall('setSignType', [$this->config->get('sign_type')])
            ->addMethodCall('setTimestampFormat', [$this->config->get('timestamp_format')])
            ->addMethodCall('setVersion', [$this->config->get('version')]);
        $this->register('client', Client::class)
            ->setArguments([$this->config->get('base_url'),new Reference('taibao_config')])
            ->setFactory([ClientFactory::class,'create']);
        $this->register('http_client', HttpClient::class)
            ->addArgument(new Reference('client'));
    }
    private function _registerCallback(): void
    {
        $this->register('request', Request::class)
            ->setFactory([Request::class, 'createFromGlobals']);
        $this->register('tb_biz_data_crypt', TaiBaoBizDataCrypt::class)
            ->addMethodCall('setRsaPublicKey', [$this->opensslPublicKey()])
            ->addMethodCall('setRsaPrivateKey', [$this->opensslPrivateKey()])
        ->addMethodCall('setCipher', [$this->config->get('cipher')]);
        $this->register('callback', Callback::class)
            ->setArguments([new Reference('request'), new Reference('tb_biz_data_crypt')]);
    }
    protected function opensslPublicKey():string {
        return is_file($this->config->get('public_key'))?file_get_contents($this->config->get('public_key')):$this->config->get('public_key');
    }
    protected function opensslPrivateKey():string {
        return is_file($this->config->get('private_key'))?file_get_contents($this->config->get('private_key')):$this->config->get('private_key');
    }
}
