<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Review]].
 *
 * @see Review
 */
class ReviewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Review[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Review|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
