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
            <h1 class="page-title">生产单</h1>
        </div>
        <div class="main-content">
            <form role="form" method="GET" action="productCountList.php">
                <div class="form-group form-inline">
                    <label for="d1">日期</label>
                    <input id="d1" type="text" name="d1" class="form-control"/>
                    <img onclick="WdatePicker({el: 'd1'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">
                    <!--        to:&nbsp;-->
                    <!--        <input id="d2" type="text" name="d2" style="width: 100px;" />-->
                    <!--        <img onclick="WdatePicker({el: 'd2'})" src="My97DatePicker/skin/datePicker.gif" width="16" height="22" align="absmiddle">-->
                </div>
                <input type="hidden" id="store_code" name="store_code" value="<?php echo $_GET['store_code']?>" />
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
    </div>
    <?php
    include_once("template_footer.html");
?>