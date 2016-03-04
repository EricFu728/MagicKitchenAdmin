<?php
/**
 * Created by PhpStorm.
 * User: fugong
 * Date: 4/01/2016
 * Time: 9:58 AM
 */
function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        $array[$key] = $value;
    }
    return $array;
}

if($_GET['type']==1){
    function productList($d1,$store_code,$language_id){
        $ch = curl_init();
        $url = "http://localhost/dp/index.php/mkv1/Mk_admin/productTotal?date=$d1&store_code=$store_code&language_id=$language_id";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($output);
        $arr = std_class_object_to_array($arr);
        return $arr;
    }
    $d1 = $_GET['d1'];
    //$d2 = $_GET['d2'];
    $store_code = $_GET['store_code'];
    $language_id = $_GET['language_id'];
    //if($d1==''||$d2=='') exit("Please Enter Valid Date");
    if($d1=='') exit("Please Enter Valid Date");
    $list = productList($d1,$store_code,$language_id);
//    $result = array();
//    foreach($list as $k=>$v){
//        $result[$v['date_delivery']][$v['product_id']]['total'] += $v['sum_quantity'];
//        if($v['bt']!='po_group'){
//            $result[$v['date_delivery']][$v['product_id']]['name'] = $v['chs_name'];
//            $result[$v['date_delivery']][$v['product_id']]['delivery_time'][$v['delivery_time']] = $v['sum_quantity'];
//        }else{
//            $result[$v['date_delivery']][$v['product_id']]['name'] = $v['chs_name'];
//
//        }
//    }
    ?>
    <html>
        <head>
            <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
        </head>
        <body >

        <div class="container">
            <div class="page-header">
                <h1>订单查询打印系统</h1>
                <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;" onclick="printitem();" />
            </div>

            <div id="printZone">
            <?php foreach($list as $k=>$v1){?>
                <h3><?php echo $k."---预定菜品统计"?></h3>
                <?php foreach($v1 as $k2=>$v2){ $i=1;$sum_qty=0;?>
            <table class="table">
                <caption><?php echo is_array($v2['name'])?$v2['name'][0]:$v2['name'];?></caption>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>配送时间</th>
                        <th>数量</th>
                    </tr>
                </thead>
                <?php foreach($v2['delivery_time'] as $k3=>$v3){ $sum_qty+=$v3;?>
                <tr>
                    <td><?php echo $i++?></td>
                    <td><?php echo $k3?></td>
                    <td><?php echo $v3?></td>
                </tr>
                <?php }?>
                <tr>
                    <td>*</td>
                    <td></td>
                    <td><?php echo "<ins>总计:  $sum_qty</ins>";?></td>
                </tr>
            </table>
                <?php }?>
            <?php }?>
                </div>
        </div>
        </body>
    </html>
<?php }elseif($_GET['type'] ==2){
    function productList2($d1,$store_code,$language_id,$true_store_code){
        $ch = curl_init();
        $url = "http://localhost/dp/index.php/mkv1/Mk_admin/totalProductByLocation?date=$d1&store_code=$store_code&language_id=$language_id&true_store_code=$true_store_code";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($output);
            $arr = std_class_object_to_array($arr);
        return $arr;
    }

//    function deliveryLocation($id){
//        $ch = curl_init();
//        $url = "http://localhost/dp/index.php/mkv1/location_api/deliveryLocationInfoById?delivery_location_id=$id";
//        curl_setopt($ch,CURLOPT_URL,$url);
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//        $output = curl_exec($ch);
//        curl_close($ch);
//        $arr = json_decode($output);
//        return $arr;
//    }
    $d1 = $_GET['d1'];
    //$d2 = $_GET['d2'];
    //if(!$d1||!$d2) exit("Please Enter Valid Date!");
    if(!$d1) exit("Please Enter Valid Date!");
    $store_code = $_GET['store_code'];
    $true_store_code = $_GET['true_store_code'];
    //$bt = $_GET['bt'];
    //if(!$bt) exit("Please Select a business type!");
    //$id = $_GET['id'];
    //$time = $_GET['time'];
    $language_id = $_GET['language_id'];
    $list = productList2($d1,$store_code,$language_id,$true_store_code);
    ?>
    <html>
    <head>
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
    </head>
    <body>

    <div class="container">
        <div class="page-header">
            <h1>订单查询打印系统</h1>
            <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;"
                   onclick="printitem();"/>
        </div>


        <div id="printZone">
            <?php foreach ($list as $k0 => $v0) { ?>
                <?php foreach ($v0 as $k1 => $v1) { if(!$v1){continue;}?>
            <div style="page-break-after: always">
            <h3><?php echo $k1 . "#" . $k0 . "---预定菜品统计" ?></h3>
                    <?php foreach ($v1 as $k2 => $v2) {
                        $i = 1; $sum_quantity = 0;?>
                        <table class="table">
                            <caption><?php echo is_array($v2['name']) ? $v2['name'][0] : $v2['name']; ?></caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>配送时间</th>
                                <th>数量</th>
                            </tr>
                            </thead>
                            <?php foreach ($v2['delivery_time'] as $k3 => $v3) {
                                    $sum_quantity += $v3;
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $k3 ?></td>
                                    <td><?php echo $v3 ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>*</td>
                                <td></td>
                                <td><?php echo "<ins>总计:  $sum_quantity</ins>"; ?></td>
                            </tr>
                        </table>
                    <?php } ?>
</div>
                <?php } ?>
            <?php } ?>
        </div>
    </body>
    </html>
<?php }elseif($_GET['type']==3){
    function productList3($d1,$store_code,$language_id,$true_store_code=false,$instant=false)
    {
        $ch = curl_init();
        $url = "http://localhost/dp/index.php/mkv1/Mk_admin/orderDetailPickup?date=$d1&store_code=$store_code&language_id=$language_id&true_store_code=$true_store_code&instant=$instant";
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
    <html>
    <head>
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
        <script type="text/javascript" src="jquery.js"></script>
    </head>
    <body>

    <div class="container">
        <div class="page-header">
            <h1>订单查询打印系统</h1>
        </div>
        <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;"
               onclick="printitem();"/>

        <div id="printZone">
            <?php foreach ($list as $k0 => $v0) { ?>
            <?php foreach ($v0 as $k1 => $v1) { ?>
            <div style="page-break-after: always">
                <h3><?php $i = 1;if(!$v1){continue;}
                    echo $k1 . "#" . $k0 . "---预订取餐配送单" ?></h3>
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
                            <?php $sum_price = 0; ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $v3['mobile']; ?></td>
                            <td><?php foreach ($v3['product'] as $k4 => $v4) {
                                    echo "<p>" . $v4['chs_name'] . " ($" . $v4['price'] . ") X <mark>" . $v4['quantity'] . "</mark></p>";
                                    $sum_price += $v4['quantity'] * $v4['price'];
                                } ?></td>
                            <td><?php echo "$" . $sum_price; ?></td>
                            <td><?php echo $v3['paid'] == 1 ? '<del>已付款<del>' : '现金' ?></td>
                            <td><?php $ohid = $v3['order_history_id'];echo $instant?"<button id=\"confirmBtn_$ohid\" onclick=\"completeOrder($store_code,$ohid);\" class=\"btn btn-default\" type=\"button\">确认</button>":''?></td>

                        </tr>
                        <?php } ?>
                    </table>
<!--                        </div>-->
                <?php }?>
            </div>

                <?php } ?>
                <?php } ?>
        </div>
        </div>
    </body>
    </html>
    <?php }elseif($_GET['type']==4){
function productList4($d1,$store_code,$language_id,$instant=false)
{
    $ch = curl_init();
    $url = "http://localhost/dp/index.php/mkv1/Mk_admin/orderDetailGroup?date=$d1&store_code=$store_code&language_id=$language_id&instant=$instant";
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
<html>
<head>
    <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="jquery.js"></script>

</head>
<body>

<div class="container">
    <div class="page-header">
        <h1>订单查询打印系统</h1>
    </div>
    <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;"
           onclick="printitem();"/>

    <div id="printZone">
        <?php foreach ($list as $k0 => $v0) { ?>
                <div style="page-break-after: always">
                    <h3><?php $i = 1;
                        echo  $k0 . "---团体预订单" ?></h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>电话</th>
                                <th>地址</th>
                                <th>时间</th>
                                <th>菜单</th>
                                <th>总价</th>
                                <th>付款</th>
                                <th>操作</th>
                            </tr>

                            <?php foreach ($v0 as $k1 => $v1) { ?>
                                <tr>
                                    <?php $sum_price = 0; ?>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $v1['mobile']; ?></td>
                                    <td><?php echo "<address>".$v1['number']." ".$v1['street']."<br />".$v1['suburb']." ".$v1['state'].", ".$v1['postcode']."</address>"; ?></td>
                                    <td><?php echo $v1['delivery_time']; ?></td>
                                    <td><?php foreach ($v1['product'] as $k2 => $v2) {
                                            echo "<p>" . $v2['chs_name'] . " ($" . $v2['price'] . ") X <mark>" . $v2['quantity'] . "</mark></p>";
                                            $sum_price += $v2['quantity'] * $v2['price'];
                                        } ?></td>
                                    <td><?php echo "$" . $sum_price; ?></td>
                                    <td><?php echo $v1['paid'] == 1 ? '<del>已付款<del>' : '现金' ?></td>
                                    <td><?php $ohid = $v1['order_history_id'];echo $instant?"<button id=\"confirmBtn_$ohid\" onclick=\"completeOrder($store_code,$ohid);\" class=\"btn btn-default\" type=\"button\">确认</button>":''?></td>
                                </tr>
                            <?php } ?>
                        </table>
                </div>
        <?php } ?>
    </div>
</body>
</html>
<?php }?>

<script>
    function printitem(){
        document.body.innerHTML=document.getElementById('printZone').innerHTML;
        window.print();
        window.location.reload();
    }
    function completeOrder(store_code,order_history_id)
    {
        confirm("确认已完成订单配送?");
        $.get("http://localhost/dp/index.php/mkv1/Mk_admin/setInstantOrderStatus?store_code="+store_code+"&order_history_id="+order_history_id,function(data){
            if(data['res']==1){
                $("#confirmBtn_"+order_history_id).attr("disabled","disabled");
            }
        });
    }
</script>
