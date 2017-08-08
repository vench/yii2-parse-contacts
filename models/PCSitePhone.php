<?php

namespace  Vench\ParseContacts\Models;

use Yii;

/**
 * This is the model class for table "pc_site_phone".
 *
 * @property int $id
 * @property int $site_id
 * @property int $sessia
 * @property string $unixtimestamp
 * @property string $phone
 *
 * @property PcSite $site
 */
class PCSitePhone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pc_site_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'sessia', 'phone'], 'required'],
            [['site_id', 'sessia'], 'integer'],
            [['unixtimestamp'], 'safe'],
            [['phone'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
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

