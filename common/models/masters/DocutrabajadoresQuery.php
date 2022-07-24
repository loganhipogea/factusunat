<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Docutrabajadores]].
 *
 * @see Docutrabajadores
 */
class DocutrabajadoresQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Docutrabajadores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Docutrabajadores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
