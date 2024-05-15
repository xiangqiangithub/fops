<?php

namespace app\service;

use fop\App;
use think\Service;

class FopService extends Service
{
    public function register()
    {
        $config = config('fop');
        $this->app->bind('fop',new App($config));
    }

    public function boot()
    {
        // 服务启动
    }

}



