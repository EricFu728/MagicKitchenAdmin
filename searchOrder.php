<?php
/**
 * Created by PhpStorm.
 * User: fugong
 * Date: 25/02/2016
 * Time: 4:56 PM
 */
include_once("template_header.phtml");
?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">搜索订单</h1>
        </div>
        <div class="main-content">

            <form method="GET" action="searchResult.php" role="form">
                <div class="form-group form-inline">
                    <label for="orderUniq">订单号</label>
                    <input id="orderUniq" type="text" name="orderUniq" class="form-control"/>
                </div>
                <div class="form-group form-inline">
                    <label for="mobile">手机号</label>
                    <input id="mobile" type="text" name="mobile" class="form-control"/>
                </div>
                <div class="form-group form-inline">
                    <label for="date1">日期</label>
                    <input id="date1" type="text" name="date1" placeholder="YYYY-MM-DD" class="form-control"/>
                    <img onclick="WdatePicker({el: 'date1'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
                    <label for="d2">至</label>
                    <input id="d2" type="text" name="d2" placeholder="YYYY-MM-DD" class="form-control"/>
                    <img onclick="WdatePicker({el: 'd2'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
                    <label>(可选)</label>
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
<!--                <div class="form-group form-inline">-->
<!--                    <label for="true_store_code"></label>-->
<!--                    <select name="true_store_code" class="form-control" id="true_store_code" onchange="getTime();">-->
<!--                        <option value="">--选择配送点--</option>-->
<!--                        --><?php //foreach($store_list as $k=>$v){?>
<!--                            <option value="--><?php //echo $k;?><!--">--><?php //echo $v?><!--</option>-->
<!--                        --><?php //}?>
<!--                    </select>-->
<!--                </div>-->
                <input type="hidden" id="store_code" name="store_code" value="<?php echo $_GET['store_code']?>" />
                <input type="submit" class=" btn btn-default" value="submit" />
            </form>
        </div>
    </div>
 <?php
    include_once("template_footer.html");
?>