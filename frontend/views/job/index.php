<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

$this->title = 'Danh sách công việc';
?>
<!-- introduce -->
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container-content">
                        <!-- form search -->
                        <div class="form-search">
                            <?php $form = ActiveForm::begin(['id' => 'frmSearchjob', 'action' => Yii::$app->urlManager->createAbsoluteUrl(['job/search']), 'method' => 'get', 'options' => ['class' => 'form-horizontal']]); ?> 
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tìm công viêc</label>
                                <div class="col-sm-8 lol-xs-12">
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <input name="k" type="text" class="form-control" id="keysearch" value="<?php if(!empty($_GET['k'])){echo $_GET['k'];}?>">
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
								<option value="">Tất cả</option>
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
                        <h4>Loại hình làm việc</h4>
                        <div class="checkbox">
                            <div class="radio">
                                <label><input type="radio" name="typeProject" value="" <?php
                                    if (empty($_GET['g'])) {
                                        echo "checked";
                                    }
                                    ?>>Tất cả</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="typeProject" value="1" <?php
                                    if (!empty($_GET['g'])) {
                                        if ($_GET['g'] == 1) {
                                            echo "checked";
                                        }
                                    }
                                    ?>>Làm việc theo giờ</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="typeProject" value="2" <?php
                                    if (!empty($_GET['g'])) {
                                        if ($_GET['g'] == 2) {
                                            echo "checked";
                                        }
                                    }
                                    ?>>Làm việc theo gói</label>
                            </div>
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
                    <input id="txtTypeproject" name="g" type="hidden" value="<?php
                    if (!empty($_GET['g'])) {
                        echo $_GET['g'];
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
                <div class="col-md-9 col-sm-12 col-xs-12 search-jobs">
                    <div class="search-result">
                        <h4>Danh sách công việc</h4>
                        <?php
                        if (!empty($model)) {
                            foreach ($model as $value) {
                                echo $this->render('_jobItem', ['value' => $value]);
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center">
                                        <p><i class="fa fa-exclamation-circle"></i> Rất tiếc, không tìm thấy công việc nào theo tiêu chí.</p>
                                        <p>Vui lòng thử lại hoặc liên hệ HOTLINE <strong>1900 1088</strong> để được hỗ trợ. </p>
                                    </div>';
                        }
                        ?>

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



<?= $this->render('/job/_bidjs') ?>
<?= $this->registerJs("$('.like').click(function(event) {
        event.preventDefault();
        var job_id = $(this).attr('data-bind');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/savejob"]) . "',
            type: 'post',
            data: {job_id:job_id},
            success: function(data) {
                if(data==2){
                $('.like-'+job_id+' span').html('Đã lưu');
                } else {
                 $('.like-'+job_id+' span').html('Lưu việc');
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
<!-- choice typr of project -->
<?= $this->registerJs("
    $(document).ready(function(){
        $('input:radio[name=typeProject]').click(function() {
            $('#txtTypeproject').val($(this).val());
            requestQuery();
        }); 
    })
") ?>

<?= $this->registerJs(" 
    function requestQuery(){
		var k = $('#keysearch').val();
        var t = $('#txtCategory').val();
        var s = $('#txtSector').val();
	var g = $('#txtTypeproject').val();
        var l = $('#txtLevel').val();
        var ps = $('#txtPricestart').val();
        var pe = $('#txtPriceend').val();
        var c = $('#txtCity').val();
        var d = $('#txtDistrict').val();
        var href ='';
        var a = '?k='+k;
        if(t){ t = '&t='+t; }else{t=''}
        if(s){ s = '&s='+s.substr(0, s.length-1); }else{s=''}
	if(g){ g = '&g='+g; }else{g=''}
        if(l){ l = '&l='+l.substr(0, l.length-1); }else{l=''}
        if(ps){ ps = '&ps='+ps.substr(0, ps.length-1); }else{ps=''}
        if(pe){ pe = '&pe='+pe.substr(0, pe.length-1); }else{pe=''}
        if(c){ c = '&c='+c.substr(0, c.length-1); }else{c=''}
        if(d){ d = '&d='+d.substr(0, d.length-1); }else{d=''} 

        if(a || t || s || l || ps || pe || c || d){
            var href = '" . Yii::$app->urlManager->createAbsoluteUrl(['job/fillter']) . "'+a+t+s+g+l+ps+pe+c+d;
            window.location.href = href;     
        } 
    }
") ?>
