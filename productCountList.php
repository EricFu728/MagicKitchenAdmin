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
function productList($d1,$store_code,$language_id){
    $ch = curl_init();
    $url = NEW_DP_URL."index.php/mkv1/Mk_admin/productTotal?date=$d1&store_code=$store_code&language_id=$language_id"."&user_id=".$_SESSION['user_id']."&access_token=".$_SESSION['access_token'];
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

?>

<div class="content">
    <div class="header">
        <h1 class="page-title">生产单</h1>
        <input type="button" value="打印" class="btn btn-default" style="float: right;width: 100px;" onclick="printitem();" />
    </div>
        <div id="printZone">
            <?php foreach($list as $k=>$v1){?>
                <h3><?php echo $k."---生产单"?></h3>
                <?php foreach($v1 as $k2=>$v2){ $i=1;$sum_qty=0;?>
                    <table class="table">
                        <caption><?php echo is_array($v2['model'])?$v2['model'][0].' - ':$v2['model'].' - ';echo is_array($v2['name'])?$v2['name'][0]:$v2['name'];?></caption>
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
                            <td>***</td>
                            <td></td>
                            <td><?php echo "<ins>总计:  $sum_qty</ins>";?></td>
                        </tr>
                    </table>
                <?php }?>
            <?php }?>
        </div>
</div>
<?php
    include_once("template_footer.html");
?>