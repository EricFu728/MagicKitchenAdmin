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
function productList4($d1,$store_code,$language_id,$instant=false)
{
    $ch = curl_init();
    $url = NEW_DP_URL."index.php/mkv1/Mk_admin/orderDetailGroup?date=$d1&store_code=$store_code&language_id=$language_id&instant=$instant"."&user_id=".$_SESSION['user_id']."&access_token=".$_SESSION['access_token'];
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);
    curl_close($ch);
    $arr = json_decode($output);
    $arr = std_class_object_to_array($arr);
    return $arr;
}
$d1 = $_GET['d1'];
//$d2 = $_GET['d2'];
if($d1=='') exit("Please Enter Valid Date");
$store_code = $_GET['store_code'];
$language_id = $_GET['language_id'];
$instant = isset($_GET['instant'])?$_GET['instant']:'';
$list = productList4($d1,$store_code,$language_id,$instant);
?>

<div class="content">
    <div class="header">
        <h1 class="page-title"><?php echo $_GET['instant']?"即时-配送订单":"预订-配送订单"?></h1>
        <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;" onclick="printitem();" />
    </div>
    <div id="printZone" class="main-content">
        <?php foreach ($list as $k0 => $v0) { ?>
            <div class="" style="page-break-after: always">
                <h3><?php $i = 1;
                    echo  $_GET['instant']?$k0 . "---"."即时-配送订单":$k0 . "---"."预订-配送订单" ?></h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>联系方式</th>
<!--                        <th>地址</th>-->
<!--                        <th>时间</th>-->
                        <th>菜单</th>
                        <th>总价</th>
                        <th>付款</th>
                        <th>操作</th>
                    </tr>

                    <?php foreach ($v0 as $k1 => $v1) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $v1['mobile']."<br><br>"; ?>
                            <?php echo "<address>".$v1['number']." ".$v1['street']."<br />".$v1['suburb']." ".$v1['state'].", ".$v1['postcode']."</address>"; ?>
                            <?php echo "<u>时间: ".$v1['delivery_time']."</u>"; ?></td>
                            <td><?php foreach ($v1['product'] as $k2 => $v2) {
                                    echo "<p>" . $v2['chs_name'] . " X <mark>" . $v2['quantity'] . "</mark></p>";
                                } ?></td>
                            <td><?php echo "$" . $v1['total']; ?></td>
                            <td><?php echo $v1['paid'] == 1 ? '<del>已付款<del>' : '现金' ?></td>
                            <td><?php $ohid = $v1['order_history_id'];echo $instant?"<button id=\"confirmBtn_$ohid\" onclick=\"completeOrder($store_code,$ohid);\" class=\"btn btn-default\" type=\"button\">确认</button>":''?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </div>
</div>

<?php
    include_once("template_footer.html");
?>