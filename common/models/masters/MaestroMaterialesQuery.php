<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[MaestroMateriales]].
 *
 * @see MaestroMateriales
 */
class MaestroMaterialesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MaestroMateriales[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MaestroMateriales|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
