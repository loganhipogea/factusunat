<?php foreach ($fields as $field): ?>
   if(!$this->existsColumn($this->table,'<?=$field?>')){  
        $this->addColumn('<?=
            $table
        ?>', '<?=
            $field['property']
        ?>', $this-><?=
            $field['decorators']
        ?>);
     }
<?php endforeach;

echo $this->render('_addForeignKeys', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
