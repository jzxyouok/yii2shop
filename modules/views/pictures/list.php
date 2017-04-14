<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '相册列表';
$this->params['breadcrumbs'][] = ['label' => '相册管理', 'url' => ['/admin/pictures/list']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/admin/css/compiled/gallery.css');
$css = <<<CSS
.img-box>a{
    display: inline-block;
}
.img-container{
        position: relative;
    }
span.icon.edit {
    display: inline-block;
    left:20%;
}
.gallery .img-container .icon.edit{
    left:20%;
}
.gallery .img-container .icon.trash{
    left:60%;
}
.gallery .img-container span.edit {
    top: 30%;
}
.gallery .img-container span.trash {
    top: 30%;
}
span.icon.trash {
    display: inline-block;
}
CSS;
$this->registerCss($css);
?>

  <!-- main container -->

        
        <div class="container-fluid">
            <div id="pad-wrapper" class="gallery">
                <div class="row-fluid header">
                    <h3>相册</h3>                    
                </div>

                <!-- gallery wrapper -->
                <div class="gallery-wrapper">
                    <div class="row gallery-row">
                        <!--图片-->
                        <?php foreach($model as $pic): ?>
                        <?php  $images = $pic->pictures;?>
                        <?php foreach((array)json_decode($images,true) as $k=>$picture) :?>
                        <div class="span3 img-container">
                            <div class="img-box">
                                <a href="<?php echo yii\helpers\Url::to(['pictures/modify','key'=>$k,'pictureid'=>$pic->pictureid]); ?>">
                                    <span class="icon edit">
                                        <i class="gallery-edit"></i>
                                    </span>
                                </a>
                                <a href="<?php echo yii\helpers\Url::to(['pictures/removepic','key'=>$k,'pictureid'=>$pic->pictureid]); ?>">
                                    <span class="icon trash">
                                        <i class="gallery-trash"></i>
                                    </span>
                                </a>
                                    <img src="<?php echo $picture; ?>-picsmall" width="100%" height="100%"/>
                                <p class="title">
                                    Beach pic title
                                </p>
                            </div>
                            <div class="popup" style="display: none">
                                <div class="pointer">
                                    <div class="arrow"></div>
                                    <div class="arrow_border"></div>
                                </div>
                                <i class="close-pop table-delete"></i>
                                <h5>编辑图片</h5>
                                <div class="thumb">
                                    <img src="<?php echo $picture; ?>-piclistsmall" />
                                </div>
                                <div class="title">
                                    <input type="text" class="inline-input" placeholder="Title" readonly="readonly"  value="<?php echo date('Y-m-d H:i:s',$pic->createtime); ?>" />
                                    <div class="ui-select">
                                        <select>
                                          <option /><?php echo $pic->pictureid; ?>
                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="description">
                                    <h6>Description</h6>
                                    <textarea></textarea>
                                    <input type="submit" value="Save" class="btn-glow primary" />
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                        
                        
                        <div class="span3 new-img"> 
                            <div id="preview">  
                                <img src="/admin/img/new-gallery-img.png"/>
                            </div>   
                        </div>
                    </div>
                    
                </div>
                <!-- end gallery wrapper -->
            </div>
        </div>
        <ul>
            <?php foreach($model as $pic): ?>
                <span><?php echo $pic->createtime; ?></span>
                <?php  $images = $pic->pictures;?>
                <?php foreach((array)json_decode($images,true) as $k=>$picture) :?>
                    <img src="<?php echo $picture; ?>-picsmall" width="100px" height="100px"/>
                    <?php echo $pic->pictureid; ?>
                    <a href="<?php echo yii\helpers\Url::to(['pictures/removepic','key'=>$k,'pictureid'=>$pic->pictureid]); ?>">删除</a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- end main container -->

<?php

$js = <<<JS
    $(function(){
       
        $(document).on('mouseover','.img-container',function(){
            $('.img-container').hover(function(){ 
                    $(this).children('.popup').show();
                },function(){
                    $(this).children('.popup').hide();
                });
        })
        $('.span3.new-img').click(function(){
            // alert(233);
            $('.span3.img-container:last').after('<div class="span3 img-container" >\
                            <div class="img-box">\
                                <span class="icon edit">\
                                    <i class="gallery-edit"></i>\
                                </span>\
                                <span class="icon trash">\
                                    <i class="gallery-trash"></i>\
                                </span>\
                                <div id="preview">\
                                    <img src="/admin/img/gallery2.jpg"/>\
                                </div>\
                                <input type="file" onchange="previewImage(this)" style="display: none;" id="previewImg">\
                                <p class="title">\
                                    Beach pic title 2 \
                                </p>\
                            </div>\
                            <div class="popup" style="display: none">\
                                <div class="pointer">\
                                    <div class="arrow"></div>\
                                    <div class="arrow_border"></div>\
                                </div>\
                                <i class="close-pop table-delete"></i>\
                                <h5>Edit Image</h5>\
                                <div class="thumb">\
                                    <img src="/admin/img/gallery-preview.jpg" />\
                                </div>\
                                <div class="title">\
                                    <input type="text" class="inline-input" placeholder="Title" />\
                                    <div class="ui-select">\
                                        <select>\
                                          <option />Category\
                                          <option />Mountains\
                                          <option />Lake and rivers\
                                        </select>\
                                    </div>\
                                </div>\
                                <div class="description">\
                                    <h6>Description</h6>\
                                    <textarea></textarea>\
                                    <input type="submit" value="Save" class="btn-glow primary" />\
                                </div>\
                            </div> \
                        </div>');

        })
        
        
    });
JS;
$this->registerJs($js);
?>