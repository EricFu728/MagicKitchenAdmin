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
function productList3($d1,$store_code,$language_id,$true_store_code=false,$instant=false)
{
    $ch = curl_init();
    $url = NEW_DP_URL."index.php/mkv1/Mk_admin/orderDetailPickup?date=$d1&store_code=$store_code&language_id=$language_id&true_store_code=$true_store_code&instant=$instant"."&user_id=".$_SESSION['user_id']."&access_token=".$_SESSION['access_token'];
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
$true_store_code = $_GET['true_store_code'];
$language_id = $_GET['language_id'];
$instant = isset($_GET['instant'])?$_GET['instant']:'';
$list = productList3($d1,$store_code,$language_id,$true_store_code,$instant);
?>

<div class="content">
    <div class="header">
        <h1 class="page-title"><?php echo $_GET['instant']?"即时":"预订"?>-取餐订单</h1>
        <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;" onclick="printitem();" />
    </div>
    <div id="printZone">
        <?php foreach ($list as $k0 => $v0) { ?>
            <?php foreach ($v0 as $k1 => $v1) { ?>
                <div class="table-container" style="page-break-after: always">
                    <h3><?php $i = 1;if(!$v1){continue;}
                        echo $_GET['instant']?$k1 . "#" . $k0 . "---"."即时-取餐配送单":$k1 . "#" . $k0 . "---"."预订-取餐配送单" ?></h3>
                    <?php foreach($v1 as $k2=>$v2){?>
                        <!--                    <div style="page-break-after: always">-->
                        <table class="table">
                            <caption><?php echo "取餐时间: $k2"; ?></caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>电话</th>
                                <th>菜单</th>
                                <th>总价</th>
                                <th>付款</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($v2 as $k3 => $v3) { ?>
                                <tr>
<!--                                    --><?php //$sum_price = 0; ?>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $v3['mobile']; ?></td>
                                    <td><?php foreach ($v3['product'] as $k4 => $v4) {
                                            echo "<p>" . $v4['chs_name'] ." X <mark>" . $v4['quantity'] . "</mark></p>";
                                        } ?></td>
                                    <td><?php echo "$" . $v3['total']; ?></td>
                                    <td><?php echo $v3['paid'] == 1 ? '<del>已付款<del>' : '现金' ?></td>
                                    <td><?php $ohid = $v3['order_history_id'];echo $instant?"<button id=\"confirmBtn_$ohid\" onclick=\"completeOrder($store_code,$ohid);\" class=\"btn btn-default\" type=\"button\">确认</button>":''?></td>

                                </tr>
                            <?php } ?>
                        </table>
                    <?php }?>
                </div>

            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php
    include_once("template_footer.html");
?>