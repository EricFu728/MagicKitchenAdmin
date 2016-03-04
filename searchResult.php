<?php
/**
 * Created by PhpStorm.
 * User: fugong
 * Date: 25/02/2016
 * Time: 4:56 PM
 */
include_once("template_header.phtml");

function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        $array[$key] = $value;
    }
    return $array;
}
function result($store_code,$language_id,$mobile='',$uni_order_uniq='',$d1='',$d2='')
{
    $ch = curl_init();
    $url = NEW_DP_URL."index.php/mkv1/Mk_admin/getOrderInfo?date1=$d1&date2=$d2&store_code=$store_code&language_id=$language_id&mobile=$mobile&order_history_uniq=$uni_order_uniq"."&user_id=".$_SESSION['user_id']."&access_token=".$_SESSION['access_token'];
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);
    curl_close($ch);
    $arr = json_decode($output);
    $arr = std_class_object_to_array($arr);
    return $arr;
}
function storeList($store_code)
{
    $ch = curl_init();
    $url = NEW_DP_URL."index.php/mkv1/Mk_admin/storeList?store_code=$store_code"."&user_id=".$_SESSION['user_id']."&access_token=".$_SESSION['access_token'];
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output=curl_exec($ch);
    curl_close($ch);
    $arr = std_class_object_to_array(json_decode($output));
    return $arr;
}
$d1 = $_GET['date1'];
$d2 = $_GET['d2'];
$store_code = $_GET['store_code'];
$order_history_uniq = $_GET['orderUniq'];
$language_id = $_GET['language_id'];
$mobile = $_GET['mobile'];
$list = result($store_code,$language_id,$mobile,$order_history_uniq,$d1,$d2);
$store_list = storeList($_GET['store_code']);
?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">订单查询结果</h1>
            <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;"
                   onclick="printitem();"/>
        </div>
        <div id="printZone">
            <div class="table-container" style="page-break-after: always">
                <table class="table">
                    <caption></caption>
                    <thead>
                    <tr>
                        <th>电话/类型/订单号</th>
<!--                        <th>类型</th>-->
                        <th>地址/时间</th>
<!--                        <th>时间</th>-->
                        <th>菜单</th>
                        <th>总价</th>
                        <th>付款</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <?php foreach($list as $order){?>
                    <tr>
                        <td><?php echo $order['mobile']?><br><?php echo $order['bt']=='po_individual'?'取餐':'配送';?><br><?php echo $order['order_history_uniq']?></td>
<!--                        <td>--><?php //echo $order['bt']=='po_individual'?'取餐':'配送';?><!--</td>-->
                        <td><?php echo $order['bt']=='po_individual'?"<address>".$store_list[$order['store_code']]."</address>":"<address>".$order['number']." ".$order['street']."<br />".$order['suburb']." ".$order['state'].", ".$order['postcode']."</address>";?>
                            <?php echo $order['date_delivery'].'<br>'.$order['delivery_time']?>
                        </td>
<!--                        <td>--><?php //echo $order['date_delivery'].' '.$order['delivery_time']?><!--</td>-->
                        <td><?php foreach ($order['product'] as $k2 => $v2) {
                                echo "<p>" . $v2['chs_name'] .  " X <mark>" . $v2['quantity'] . "</mark></p>";
                            } ?></td>
                        <td><?php echo "$".$order['total'];?></td>
                        <td><?php echo $order['paid'] == 1 ? '<del>已付款<del>' : '现金' ?></td>
                        <td><?php if($order['order_status']=='100'||$order['order_status']=='200'){
                                echo '未处理';
                            }elseif($order['order_status']=='132'||$order['order_status']=='232'){
                                echo '待配送';
                            }elseif($order['order_status']=='133'||$order['order_status']=='233'){
                                echo '完成';
                            } ?></td>
                        <td><?php if($order['order_status']!='133'&&$order['order_status']!='233'){
                                $ohid = $order['order_history_id'];
                                echo "<button id=\"confirmBtn_$ohid\" onclick=\"completeOrder($store_code,$ohid);\" class=\"btn btn-default\" type=\"button\">确认</button>";
                            }?></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
<?php
    include_once("template_footer.html");
?>
