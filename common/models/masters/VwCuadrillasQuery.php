<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[VwCuadrillas]].
 *
 * @see VwCuadrillas
 */
class VwCuadrillasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwCuadrillas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwCuadrillas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
