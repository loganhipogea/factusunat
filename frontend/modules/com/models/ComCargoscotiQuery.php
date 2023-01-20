<?php
namespace frontend\modules\com\models;

/**
 * This is the ActiveQuery class for [[ComCargoscoti]].
 *
 * @see ComCargoscoti
 */
class ComCargoscotiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ComCargoscoti[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ComCargoscoti|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
?>