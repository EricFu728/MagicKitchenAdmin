<?php
/**
 * Created by PhpStorm.
 * User: fugong
 * Date: 18/12/2015
 * Time: 4:44 PM
 */


function deliveryLocationList($store_code)
{
    $ch = curl_init();
    $url = "localhost/dp/index.php/mkv1/Mk_admin/storeList?store_code=$store_code";
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output=curl_exec($ch);
    curl_close($ch);
    $arr = json_decode($output);
    return $arr;
}
$store_list = deliveryLocationList($_GET['store_code']);
?>

<?php if($_GET['type']==1 || $_GET['type']==4){?>
<html>
<head>
    <script type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>订单查询打印系统</h1>
        </div>

    <form role="form" method="GET" action="list.php?type=<?php echo $_GET['type']?>">
        <div class="form-group">
            <label for="d1">日期</label>
        <input id="d1" type="text" name="d1"/>
        <img onclick="WdatePicker({el: 'd1'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
<!--        to:&nbsp;-->
<!--        <input id="d2" type="text" name="d2" style="width: 100px;" />-->
<!--        <img onclick="WdatePicker({el: 'd2'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">-->
        </div>
        <input type="hidden" id="store_code" name="store_code" value="888" />
        <input type="hidden" name="type" value="<?php echo $_GET['type']?>" />
        <input type="hidden" name="instant" value="<?php echo $_GET['instant']?>" />
        <div class="form-group form-inline">
        <label for="language_id">选择语言:</label>
        <select id="language_id" class="form-control" name="language_id">
            <option value="1">中文</option>
<!--            <option value="1">English</option>-->
        </select>
        </div>
        <input type="submit" class="btn btn-default" value="submit" />
    </form>
    </div>
</body>
</html>
<?php }elseif($_GET['type']==2 || $_GET['type']==3){
    //$deliveryList = deliveryLocationList();
    ?>
    <html>
    <head>
        <script type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css">
        <script>
//            function getTime()
//            {
//                var id = $("#location").val();
//                $("#time").show();
//                $.get("http://localhost/dp/index.php/mkv1/MK_admin/deliveryTimeByLocationId?id="+id,function(data){
//                    if(data){
//                        for(var p in data){
//                            $("#time").append("<option value="+data[p]+">"+data[p]+"</option>");
//                        }
//                    }
//                });
//            }
//            function changeBt()
//            {
//                var bt = $("#bt").val();
//                if(bt=='po_individual'){
//                    $("#location").show();
//                }else{
//                    $("#location").val("");
//                    $("#location").hide();
//                    $("#time").val("");
//                    $("#time").hide();
//                }
//            }
        </script>
    </head>
    <body>
    <div class="container">
        <div class="page-header">
            <h1>订单查询打印系统</h1>
        </div>
    <form method="GET" action="list.php?type=<?php echo $_GET['type']?>" role="form">
        <div class="form-group">
            <label for="d1">日期</label>
            <input id="d1" type="text" name="d1"/>
            <img onclick="WdatePicker({el: 'd1'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
            <!--        to:&nbsp;-->
            <!--        <input id="d2" type="text" name="d2" style="width: 100px;" />-->
            <!--        <img onclick="WdatePicker({el: 'd2'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">-->
        </div>
        <div class="form-group form-inline">
            <label for="language_id">选择语言:</label>
            <select id="language_id" class="form-control" name="language_id">
                <option value="1">中文</option>
<!--                <option value="1">English</option>-->
            </select>
        </div>
<!--        <select id="bt" name="bt" onchange="changeBt();">-->
<!--            <option value="">--选择订单类型--</option>-->
<!--            <option value="po_individual">个人取餐</option>-->
<!--            <option value="po_group">团体订餐</option>-->
<!--        </select>-->
        <div class="form-group form-inline">
            <label for="true_store_code"></label>
        <select name="true_store_code" class="form-control" id="true_store_code" onchange="getTime();">
            <option value="">--选择配送点--</option>
            <?php foreach($store_list as $k=>$v){?>
            <option value="<?php echo $k;?>"><?php echo $v?></option>
            <?php }?>
        </select>
        </div>
        <input type="hidden" id="store_code" name="store_code" value="888" />
        <input type="hidden" id="type" name="type" value="<?php echo $_GET['type']?>" />
        <input type="hidden" id="instant" name="instant" value="<?php echo $_GET['instant']?>" />
        <input type="submit" class=" btn btn-default" value="submit" />
    </form>
        </div>
    </body>
    </html>
<?php }?>