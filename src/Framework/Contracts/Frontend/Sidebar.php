<?php

namespace Laracore\Core\Framework\Contracts\Frontend;

interface Sidebar
{
    /**
     * 根据 model 获取对应 Sidebar
     *
     * @param  string  $model
     * @return mixed
     */
    public function get($model);
    /**
     * 处理对应配置数据
     */
    public function handler($configs);
}
