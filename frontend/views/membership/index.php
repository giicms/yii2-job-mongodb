
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Danh sách nhân viên';
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-container">
                        <h3>Chọn nhân viên phù hợp với công việc của bạn.</h3>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container-content">
                        <!-- form search -->
                        <div class="form-search">
                            <?php $form = ActiveForm::begin(['id' => 'frmSearchmember', 'action' => Yii::$app->urlManager->createAbsoluteUrl(['membership/search']), 'method' => 'get', 'options' => ['class' => 'form-horizontal']]); ?> 
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tìm nhân viên</label>
                                <div class="col-sm-8 lol-xs-12">
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <input name="k" type="text" class="form-control">
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <button type="submit" class="btn btn-blue"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <!-- End form search -->
                    </div>

                </div>    
            </div>
            <div class="row">
                <!-- sidebar -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="search-cat">
                        <h4>Danh mục ngành nghề</h4>
                        <div class="select">
                            <select id="jobCategory" class="form-control">
                                <?php foreach ($category as $value) { ?>
                                    <option value="<?= $value->_id ?>" <?php
                                    if (!empty($_GET['t'])) {
                                        if ($value->_id == $_GET["t"]) {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?= $value->name ?></option>
                                        <?php } ?>    
                            </select>
                        </div>
                        <h4>Chuyên mục</h4>
                        <div id="jobSector" class="checkbox">
                            <?php
                            foreach ($category as $k => $value) {
                                foreach ($value->getJobsector((string) $value->_id) as $value) {
                                    ?>
                                    <label class="<?php
                                    if (!empty($_GET['t'])) {
                                        if ($value->category_id == $_GET['t']) {
                                            echo "active";
                                        }
                                    } else {
                                        if ($k == 0) {
                                            echo "active";
                                        }
                                    }
                                    ?> sec-<?= $value->category_id ?> item-<?= $k ?> sec-item">
                                        <input type="checkbox" value="<?= $value->_id ?>" <?php
                                        if (!empty($_GET['s'])) {
                                            if (strpos($_GET['s'], (string) $value->_id) !== false) {
                                                echo "checked";
                                            }
                                        }
                                        ?>><?= $value->name ?>
                                    </label>
                                    <?php
                                }
                            }
                            ?>     
                        </div>

                    </div>

                    <div class="search-cat"> 
                        <h4>Cấp độ nhân viên</h4>
                        <div id="jobLevel" class="checkbox">
                            <?php foreach ($level as $value) { ?>
                                <label>
                                    <input type="checkbox" value="<?= $value->_id ?>" <?php
                                    if (!empty($_GET['l'])) {
                                        if (strpos($_GET['l'], (string) $value->_id) !== false) {
                                            echo "checked";
                                        }
                                    }
                                    ?>>
                                           <?= $value->name ?>
                                </label>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="search-cat"> 
                        <h4>Vị trí địa lý</h4>
                        <div id="selectCity" class="checkbox">
                            <?php foreach ($city as $value) { ?>
                                <label>
                                    <input type="checkbox" value="<?= $value->_id ?>" <?php
                                    if (!empty($_GET['c'])) {
                                        if (strpos($_GET['c'], (string) $value->_id) !== false) {
                                            echo "checked";
                                        }
                                    }
                                    ?>>
                                           <?= $value->name ?>
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'frmFilltermember', 'action' => 'fillter', 'method' => 'get', 'options' => ['class' => 'form-horizontal']]); ?> 
                    <input id="txtCategory" name="t" type="hidden" value="<?php
                    if (!empty($_GET['t'])) {
                        echo $_GET['t'];
                    }
                    ?>" >
                    <input id="txtSector" name="s" type="hidden" value="<?php
                    if (!empty($_GET['s'])) {
                        echo $_GET['s'] . ',';
                    }
                    ?>" >
                    <input id="txtLevel" name="l" type="hidden" value="<?php
                    if (!empty($_GET['l'])) {
                        echo $_GET['l'] . ',';
                    }
                    ?>" >
                    <input id="txtPricestart" name="ps" type="hidden" value="" >
                    <input id="txtPriceend" name="pe" type="hidden" value="" >
                    <input id="txtCity" name="c" type="hidden" value="<?php
                    if (!empty($_GET['c'])) {
                        echo $_GET['c'] . ',';
                    }
                    ?>" >
                    <input id="txtDistrict" name="d" type="hidden" value="" >
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- End sidebar -->

                <!-- main content -->
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="search-result">
                        <h4>Danh sách nhân viên</h4>
                        <?php
                        if (!empty($model)) {
                            foreach ($model as $value) {
                                echo $this->render('_memberItem', ['value' => $value]);
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center">
                                        <p><i class="fa fa-exclamation-circle"></i> Rất tiếc, không tìm thấy nhân viên nào theo tiêu chí.</p>
                                        <p>Vui lòng thử lại hoặc liên hệ HOTLINE <strong>1900 1088</strong> để được hỗ trợ. </p>
                                    </div>';
                        }
                        ?>
                        <!-- End member item -->

                        <div class="row">
                            <div class="col-lg-12 nav-pagination">
                                <nav>
                                    <?php
                                    echo LinkPager::widget(['pagination' => $pages,
                                        'options' => ['class' => 'pagination pull-right'],
                                        'firstPageLabel' => 'Trang đầu',
                                        'lastPageLabel' => 'Trang cuối',
                                        'prevPageLabel' => 'Trang trước',
                                        'nextPageLabel' => 'Trang sau',
                                    ]);
                                    ?>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End main content -->

            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<div class="modal fade" id="invited" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mời nhận việc</h4>
            </div>
            <div class="modal-body">
                                <p class="invited-error">Nhân viên này không đúng lĩnh vực nghành nghề bạn cần.!</p>
                <?php
                if (!empty($job)) {
                    ?>
                    <?php $form = ActiveForm::begin(['id' => 'formInvited', 'options' => ['class' => 'form-horizontal']]); ?>  
                    <div class="form-group">
                        <label class="col-sm-3">Nhân viên</label>
                        <div class="col-sm-9">
                            <strong class="actor-name"></strong>
                            <input type="hidden" id="jobinvited-actor" name="JobInvited[actor]" value="">
                        </div>
                    </div>


                    <?= $form->field($invited, 'message', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label" style="text-align:left">{label}</label><div  class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                    <div class="form-group">
                        <label class="col-sm-3">Chọn công việc</label>
                        <div class="col-sm-9">
                            <div class="select job-invited">
                                <?= $form->field($invited, 'job_id')->dropDownList([])->label(FALSE) ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button id="submitInvited" type="submit" class="btn btn-default btn-boss">Mời nhận việc</button>
                            <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <?php
                } else {
                    echo 'Bạn chưa có công việc nào trong hệ thống!';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userBid" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Book nhân viên</h4>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin(['id' => 'formUserBid', 'options' => ['class' => 'form-horizontal']]); ?>  
                <p class="success_userbid"></p>
                <div class="form-group">
                    <label class="col-sm-3">Nhân viên</label>
                    <div class="col-sm-9">
                        <strong class="userbid-name"></strong>
                        <?= $form->field($userbid, 'actor_id')->hiddenInput()->label(FALSE) ?>
                    </div>
                </div>

                <?= $form->field($userbid, 'message', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label" style="text-align:left">{label}</label><div  class="col-md-9 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                        <button id="submitUserBid" type="submit" class="btn btn-default btn-boss">Book</button>
                        <a href="#"  data-dismiss="modal" class="alert"><strong>Hủy</strong></a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs("$(document).on('click', '.invited', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
        var user_name = $('.user-'+user_id+' .name').text();
        $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/checksector"]) . "',
            type: 'post',
            data: {user_id:user_id},
            success: function(data) {
            var html ='<option>Chọn công việc</option>';
            if(data.length>0){
                $('.invited-error').hide();
                $('#formInvited').show();
                for (index = 0; index < data.length; ++index) {
                    html += '<option value='+data[index].id+'>'+data[index].name+'</option>';
                }  
                          $('#jobinvited-job_id').html(html);
                } else{
                    $('.invited-error').show();     
                    $('#formInvited').hide();
}
      
            }
        });
    
        $('#invited').find('.modal-body .actor-name').text(user_name);
        $('#invited').find('.modal-body #jobinvited-actor').val(user_id);  
        $('#invited').modal('show');
});") ?>


<?= $this->registerJs("$(document).on('submit', '#formInvited', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["job/jobinvited"]) . "',
               type: 'post',
          data: $('form#formInvited').serialize(),
        success: function(data, status) {
          if(data){
             if(data){
             $('.success_invited').html('Đã mời nhận việc thành công');
          $('.option-'+data.actor+' .invited').remove();
                 window.setTimeout(function () {
                $('.success_invited').html('');
            }, 1000);
                      window.setTimeout(function () {
                   $('#invited').modal('hide'); 
            }, 2000);
         
}       
}
        }
    });

});

") ?>
<?= $this->registerJs("$(document).on('click', '.userbid', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
        var user_name = $('.user-'+user_id+' .name').text();
        $('#userBid').modal('show');
        $('#userBid').find('.modal-body .userbid-name').text(user_name);
        $('#userBid').find('.modal-body #userbid-actor_id').val(user_id);
    

});") ?>
<?= $this->registerJs("$(document).on('submit', '#formUserBid', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/userbid"]) . "',
               type: 'post',
          data: $('form#formUserBid').serialize(),
        success: function(data, status) {
          if(data){
             $('.success_userbid').html('Đã book thành công');
          $('.option-'+data.actor_id+' p').html('<label class=\'text-danger\'>Đã book nhân viên này</label>');
                 window.setTimeout(function () {
                $('.success_userbid').html('');
            }, 1000);
                      window.setTimeout(function () {
                   $('#userBid').modal('hide'); 
            }, 2000);
         
}
        }
    });

});

") ?>
<?= $this->registerJs("$(document).on('click', '.saved', function (event){
        event.preventDefault();
        var user_id = $(this).attr('data-id');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/saveuser"]) . "',
            type: 'post',
            data: {user_id:user_id},
            success: function(data) {
                if(data.status==0){
                $('.user-'+user_id+' a.saved').html('<i class=\"fa fa-heart-o\"></i>');
                } else {
                $('.user-'+user_id+' a.saved').html('<i class=\"fa fa-heart\"></i>');
                }
            }
        });

});") ?>


<!-- select job category -->
<?= $this->registerJs("
    $('#jobCategory').change(function(){
        $('#txtCategory').val($(this).val());
        $('#txtSector').val('');
        $('.sec-item').hide();
        $('.sec-'+$(this).val()).css('display','inline-block');
        requestQuery();
    })
") ?>

<!-- select city -->
<?= $this->registerJs("
    $(document).ready(function(){
        $('#selectCity input:checkbox').change(function(){
            var str = $('#txtCity').val();
            if($(this).is(':checked')){ 
                $('#txtCity').val(str+$(this).val()+',');
            }
            else {
                var newstr = str.replace($(this).val()+',', '');;
                $('#txtCity').val(newstr);
            }
            requestQuery();
        });
});") ?>

<!-- select level -->
<?= $this->registerJs("
    $(document).ready(function(){
        $('#jobLevel input:checkbox').change(function(){
            var str = $('#txtLevel').val();
            if($(this).is(':checked')){ 
                $('#txtLevel').val(str+$(this).val()+',');
            }
            else {
                var newstr = str.replace($(this).val()+',', '');;
                $('#txtLevel').val(newstr);
            }
            requestQuery();
        });
});") ?>

<!-- fillter job -->
<?= $this->registerJs("
    $(document).ready(function(){
        $('#jobSector input:checkbox').change(function(){
            var str = $('#txtSector').val();
            if($(this).is(':checked')){ 
                $('#txtSector').val(str+$(this).val()+',');
            }
            else {
                var newstr = str.replace($(this).val()+',', '');;
                $('#txtSector').val(newstr);
            }
            requestQuery();
        });
    });") ?>
<?= $this->registerJs(" 
    function requestQuery(){
        var t = $('#txtCategory').val();
        var s = $('#txtSector').val();
        var l = $('#txtLevel').val();
        var ps = $('#txtPricestart').val();
        var pe = $('#txtPriceend').val();
        var c = $('#txtCity').val();
        var d = $('#txtDistrict').val();
        var href ='';
        var a = '?k=1';
        if(t){ t = '&t='+t; }else{t=''}
        if(s){ s = '&s='+s.substr(0, s.length-1); }else{s=''}
        if(l){ l = '&l='+l.substr(0, l.length-1); }else{l=''}
        if(ps){ ps = '&ps='+ps.substr(0, ps.length-1); }else{ps=''}
        if(pe){ pe = '&pe='+pe.substr(0, pe.length-1); }else{pe=''}
        if(c){ c = '&c='+c.substr(0, c.length-1); }else{c=''}
        if(d){ d = '&d='+d.substr(0, d.length-1); }else{d=''} 

        if(t || s || l || ps || pe || c || d){
            var href = '" . Yii::$app->urlManager->createAbsoluteUrl(['membership/fillter']) . "'+a+t+s+l+ps+pe+c+d;
            window.location.href = href;     
        }
        
       
    }
") ?>
