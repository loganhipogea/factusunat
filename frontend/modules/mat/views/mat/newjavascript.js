$('[name$=\"][codart]\"]').on( 'change', function() { 
       var_idselect=this.id;
       var_indice=var_indice.substring(11,12);
         var urli='".\yii\helpers\Url::to(['mat/ajax-verif-transa'])."';
        var cod=$('#matvale-codmov').val();
        var promesa1= $.ajax({
           url : urli,
          type : 'POST', 
          data : {valorInput:cod}, 
          dataType: 'html', 
         error:function(xhr, status, error){ 
                            var n = Noty('id');                      
                             $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ xhr.responseText);
                              $.noty.setType(n.options.id, 'error');         
                                }, 
            success: function (data) {
               var_resultado=data;
                }
       }).then(function(){ 
        $('#matdetvale-0-um').html(var_resultado); 
       });
    
});

