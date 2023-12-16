<?php

namespace common\models\masters;

/**
 * This is the ActiveQuery class for [[MaestrocompoSol]].
 *
 * @see MaestrocompoSol
 */
class MaestrocompoSolQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MaestrocompoSol[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MaestrocompoSol|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
