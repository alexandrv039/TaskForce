<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TaskFile]].
 *
 * @see TaskFile
 */
class TaskFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaskFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaskFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
