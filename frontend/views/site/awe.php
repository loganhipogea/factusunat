<?php
use common\helpers\ComboHelper;
?>
<div class="site-index">

    <div class="body-content">
        <?php
        foreach(ComboHelper::awesomeList() as $key=>$value){
            ?>
        <div class="col-2 col-sm-2 col-md-2"> 
            <span><?=$key?></span><i style="font-size:2em;" class="fa <?=$key?>"></i>
        </div>
        
       <?php }
        
        ?>
        
            
    </div>
</div>
