<?php
if ($model) {
    ?>
    <div class="row row-item-<?= $i ?>">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="select">
                <div class="form-group field-profile-language-<?= $i ?>">

                    <select id="profile-language-<?= $i ?>" class="form-control select-ajax" data-bind="<?= $i ?>" name="Profile[language][<?= $i ?>]">
                        <option value="">Chọn ngôn ngữ</option>
                        <?php
                        if (!empty($model)) {
                            foreach ($model as $value) {
                                ?>
                                <option value="<?= (string) $value->_id ?>"><?= $value->name ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>                               
            </div>
        </div>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="select">
                <div class="form-group field-profile-language_level-<?= $i ?>">

                    <select id="profile-language_level-<?= $i ?>" class="form-control profile-language-<?= $i ?>" name="Profile[language_level][<?= $i ?>]">
                        <option value="0">Chọn cấp độ</option>
                    </select>
                </div>                     
            </div>             
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 option">
            <a class="btn btn-blue add" id="add-<?= $i ?>" data-bind="<?= $i ?>" href="javascript:void(0)"><i class="fa fa-plus"></i></a>
        </div>
    </div>
    <?php
}
?>