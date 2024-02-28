<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatActivos]].
 *
 * @see MatActivos
 */
class MatActivosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatActivos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatActivos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    
    public function equipos(){
         $this->andWhere('esequipo', '1');
    }
}
