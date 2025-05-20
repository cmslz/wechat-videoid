<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/5 下午3:24
 */

namespace Cmslz\WechatVideoid;

use Cmslz\WechatVideoid\Application\AfterSale;
use Cmslz\WechatVideoid\Application\Category;
use Cmslz\WechatVideoid\Application\Common;
use Cmslz\WechatVideoid\Application\Delivery;
use Cmslz\WechatVideoid\Application\Goods;
use Cmslz\WechatVideoid\Application\League;
use Cmslz\WechatVideoid\Application\Order;
use Cmslz\WechatVideoid\Application\Shop;
use Cmslz\WechatVideoid\Kernel\Contracts\Config as ConfigInterface;
use Cmslz\WechatVideoid\Kernel\Exceptions\InvalidClassException;

/**
 * Class Factory
 * @package Cmslz\WechatVideoid
 * Created by xiaobai at 2024/6/5 下午3:25
 * @method static Application app(array|ConfigInterface $config)
 * @method static Shop shop(array|ConfigInterface $config)
 * @method static League league(array|ConfigInterface $config)
 * @method static Order order(array|ConfigInterface $config)
 * @method static Delivery delivery(array|ConfigInterface $config)
 * @method static Goods goods(array|ConfigInterface $config)
 * @method static Common common(array|ConfigInterface $config)
 * @method static AfterSale afterSale(array|ConfigInterface $config)
 * @method static Category category(array|ConfigInterface $config)
 */
class Factory
{

    protected static $apps = [
        'app' => Application::class,
    ];

    public static function make($name, array $config)
    {
        $namespace = "\\Cmslz\\WechatVideoid\\Application\\" . ucfirst($name);
        if (!class_exists($namespace)) {
            if (!isset(self::$apps[$name])) {
                throw new InvalidClassException("{$name} not found.");
            }
            return new self::$apps[$name]($config);
        }

        $application = new Application($config);
        return new $namespace($application);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}