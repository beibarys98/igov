<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "donation".
 *
 * @property int $id
 * @property int $post_id
 * @property string $whatsapp_number
 * @property float $amount
 * @property int $created_at
 *
 * @property Post $post
 */
class Donation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'whatsapp_number', 'amount', 'created_at'], 'required', 'message' => 'Толтырыңыз!'],
            [['post_id', 'created_at'], 'integer'],
            [['amount'], 'number', 'message' => 'Мысалы: 1000', 'min' => 100, 'tooSmall' => 'Ең азы 100 тг!'],
            [['whatsapp_number'], 'string', 'max' => 20],
            ['whatsapp_number', 'match', 'pattern' => '/^(?:\+7|8)\d{10}$/', 'message' => 'Мысалы: 87771112233'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'whatsapp_number' => 'Whatsapp Number',
            'amount' => 'Amount',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\DonationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DonationQuery(get_called_class());
    }
}
