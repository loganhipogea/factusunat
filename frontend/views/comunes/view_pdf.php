<?php   
use common\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?PHP 

$ext=FileHelper::extensionFile($urlFile);
/*VAR_DUMP($ext,FileHelper::isImage($urlFile), FileHelper::extImages());
die();*/
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php 
//echo $urlFile;
//var_dump(FileHelper::isImage($urlFile));
if(FileHelper::isImage($urlFile)) { ?>
<div style="overflow:auto">
    <?php echo Html::img($urlFile,['width'=>300,'height'=>300]); ?>
</div>
<?php  }elseif($ext=='pdf') { ?>

<embed src="<?=$urlFile?>"  type="application/pdf" 
       width="<?=$width?>" height="<?=$height?>" 
 />
</div>
<?php  }else{ ?>
<?php echo Html::img(FileHelper::UrlEmptyFile()); ; ?>
<?php } ?>
