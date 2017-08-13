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
     * @param string $site
     * @param null $title
     * @return array|null|PCSite|\yii\db\ActiveRecord
     */
    public static function findBySiteOrCreate($site, $title = null) {
        $model = PCSite::find()->where('site=:site', [
            ':site' => $site,
        ])->one();
        if(is_null($model)) {
            $model = new PCSite();
            $model->site = $site;
            $model->title = !is_null($title) ? $title : $site;
            $model->save();
        }

        return $model;
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
        return $this->hasMany(PCSiteAddress::className(), ['site_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPcSiteEmails()
    {
        return $this->hasMany(PCSiteEmail::className(), ['site_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPcSitePhones()
    {
        return $this->hasMany(PCSitePhone::className(), ['site_id' => 'id']);
    }
}

