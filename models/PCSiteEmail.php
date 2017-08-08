<?php

namespace  Vench\ParseContacts\Models;

use Yii;

/**
 * This is the model class for table "pc_site_email".
 *
 * @property int $id
 * @property int $site_id
 * @property int $sessia
 * @property string $unixtimestamp
 * @property string $email
 *
 * @property PcSite $site
 */
class PCSiteEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pc_site_email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'sessia', 'email'], 'required'],
            [['site_id', 'sessia'], 'integer'],
            [['unixtimestamp'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => PcSite::className(), 'targetAttribute' => ['site_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site_id' => 'Site ID',
            'sessia' => 'Sessia',
            'unixtimestamp' => 'Unixtimestamp',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(PcSite::className(), ['id' => 'site_id']);
    }
}

