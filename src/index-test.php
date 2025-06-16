<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/5/29 下午11:14
 */

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '1G');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
!defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';

$info = include_once __DIR__ . '/../info.php';
$config = [
    'appid' => $info['appid'],
    'secret' => $info['secret'],
];
$app = \Cmslz\WechatVideoid\Factory::app($config);
$leaguePromoterApp = \Cmslz\WechatVideoid\Factory::league($config)->promoter();
$result = $leaguePromoterApp->get('spheptFWnesj8fH');
var_dump($result);
exit;

# 店铺管理API
$shopApp = \Cmslz\WechatVideoid\Factory::shop($config);
## 获取店铺基本信息Start
//$result = $shopApp->info_get();


$params = [
    'create_time_range' => [
        'start_time' => 1719124951,
        'end_time' => 1719643352,
    ],
    'page_size' => 10
];
//订单列表
$order = \Cmslz\WechatVideoid\Factory::order($config);
//$list = $order->list($params);

$orderId = '3720929517078450688';
//$orderInfo = $order->info($orderId);

//var_dump($orderInfo);die();

$deliveryParams = [
    'order_id' => $orderId,
    'delivery_list' => [
        [
            'deliver_type' => 3,
            'product_infos' => [[
                'product_cnt' => 1,
                'product_id' => '10000136458948',
                'sku_id' => '2389903532',
            ]],
            'course_info' => [
                'start_time' => 1719645892,
                'end_time' => 1720164292,
                'course_path' => [
                    'type' => 0,
                    'wxa_appid' => 'wx4b80d60e6bea5090',
                    'wxa_path' => '/sellermall/order/list-v2'
                ]
            ]
        ]
    ]
];
$delivery = \Cmslz\WechatVideoid\Factory::delivery($config);
$result = $delivery->send($deliveryParams);
var_dump($result);die();
echo(json_encode($orderInfo, 320));
die();
//array(3) {
//    ["errcode"]=>
//  int(0)
//  ["errmsg"]=>
//  string(2) "ok"
//    ["info"]=>
//  array(5) {
//        ["nickname"]=>
//    string(12) "群友店铺"
//        ["headimg_url"]=>
//    string(137) "http://mmbiz.qpic.cn/sz_mmbiz_png/IkdXU5SFJP8MTnx8MdJlwrRowlxIFJPW8TH8lNk6KTWQ1uccbQEQuAGrokxcqkDibOkdHC8QfnNSIJybibeezDag/0?wx_fmt=png/0"
//        ["subject_type"]=>
//    string(6) "企业"
//        ["status"]=>
//    string(13) "open_finished"
//        ["username"]=>
//    string(15) "gh_1afa81ab6d15"
//  }
//}
## 获取店铺基本信息End


# 优选联盟Start
$leagueApp = \Cmslz\WechatVideoid\Factory::league($config);
## 达人Start
$promoterApp = $leagueApp->promoter();
### 新增达人
$result = $promoterApp->add('spheptFWnesj8fH');

## 达人End
# 优选联盟End


var_dump($result);
exit;



//$appid = $app->getAccount()->getAppId();
//$response = $app->getClient()->postJson('api/apps/v1/qrcode/create/', [
//    'appid' => $appid,
//]);
//$result = $response->toArray(false);
//var_dump($result);