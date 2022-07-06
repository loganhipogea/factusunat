<?php
use yii\helpers\Html;
?>
<div class="bs-callout <?php //echo $cdr->isAccepted() ? 'bs-callout-success' : 'bs-callout-danger' ?>">
    <h4>Respuesta</h4><br>
    <table class="table">
        <tbody>
            <tr>
                <td>ID</td>
                <td><?=$cdr['id']?></td>
            </tr>
            <tr>
                <td>Código:</td>
                <td><?=$cdr['code']?></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><?=$cdr['description']?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <?php if (count($cdr['notes']) > 0) :?>
        <b>Notas</b><br>
        <ul class="list-group">
            <?php foreach ($cdr['notes'] as $note): ?>
                <li class="list-group-item"><?=$note?></li>
            <?php endforeach; ?>
        </ul><br>
    <?php endif;?>
    <b>Adjuntos</b><br> 
    <?php $filename=''; ?>
    <ul class="list-group">
       <?php foreach($model->files as $file) {  ?>
       <!-- <li class="list-group-item"><a target="_blank" href="files/xml"><i class="fa fa-file-code"></i>&nbsp;xml</a></li> -->
        <li class="list-group-item">
            <?php echo Html::a($file->url, $file->url, ['data-pjax'=>'0']);  ?>
            <!--<a target="_blank" title="Ver CDR" href="examples/pages/cdr-viewer.php?f=files/R-<?=$filename?>.zip"><i class="fa fa-eye"></i></a> -->
        </li>
       <?php  } ?>
    </ul>
</div>
