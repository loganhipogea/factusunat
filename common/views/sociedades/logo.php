<div style="position:absolute;
     width:180px;height:80px;
     padding:0px; top:<?php echo "100"; ?>px;
     left:<?php echo "100"; ?>px; border-style:solid; border-width:1px; border-color:#e1e1e1 ">


<div style="position:absolute; padding:1px;border-style:none; 
     top:<?php echo "100"; ?>px; left:<?php echo "100"; ?>px; ">
    				<div style="float:right">
	<?php echo \yii\helpers\Html::img($model->files[0]->getUrl(), ['width'=>300,'height'=>90]); ?>
				</div>

</div>
<div style="position:absolute;  padding:0px; float:right; left:<?php echo (100+100); ?>px; top:<?php echo (100+10); ?>px;">

							<span style="font-family:cour; font-size:4px !important;">
								<?php echo $model->despro; ?>
							</span>
	<div  >
							<span style="font-family:cour; font-size:2px !important;">
								<?php echo $model->direc; ?>
							</span>
	</div>
	
	<div >
							<span style="font-family:cour; font-size:2px !important;">
								<?php  echo $model->getAttributeLabel('telefonos')." : ".$model->telefonos;  ?>
							</span>
	</div>
	<div >
							<span style="font-family:cour; font-size:2px !important;">
								<?php  echo $model->getAttributeLabel('mail')." : ".$model->mail."    ".$model->web; ?>
							</span>
	</div>
</div>

</div>

