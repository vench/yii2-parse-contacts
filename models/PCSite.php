<?php

namespace  Vench\ParseContacts\Models;

use Yii;

/**
 * This is the model class for table "pc_site".
 *
 * @property int $id
 * @property string $title
 * @property string $site
 *
 * @property PcSiteAddress[] $pcSiteAddresses
 * @property PcSiteEmail[] $pcSiteEmails
 * @property PcSitePhone[] $pcSitePhones
 */
class PCSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pc_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site'], 'required'],
            [['title', 'site'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'site' => 'Site',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPcSiteAddresses()
    {
        return $this->hasMany(PcSiteAddress::className(), ['site_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPcSiteEmails()
    {
        return $this->hasMany(PcSiteEmail::className(), ['site_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPcSitePhones()
    {
        return $this->hasMany(PcSitePhone::className(), ['site_id' => 'id']);
    }
}

