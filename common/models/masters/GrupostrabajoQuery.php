<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[Grupostrabajo]].
 *
 * @see Grupostrabajo
 */
class GrupostrabajoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Grupostrabajo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Grupostrabajo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
