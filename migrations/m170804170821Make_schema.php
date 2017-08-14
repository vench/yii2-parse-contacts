<?php

use yii\db\Migration;

class m170804170821Make_schema extends Migration
{
    public function safeUp()
    {
    
        $this->createTable('{{pc_site}}', [
            'id'             => $this->primaryKey()->unsigned(),
            'title'          => $this->string()->null(),
            'site'           => $this->string()->notNull(), 
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->createTable('{{pc_site_phone}}', [
            'id'             => $this->primaryKey()->unsigned(),
            'site_id'        => $this->integer()->unsigned()->notNull(),
            'sessia'         => $this->integer()->unsigned()->notNull(),
            'unixtimestamp'  => $this->timestamp(),
            'phone'          => $this->string()->notNull(), 
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->createTable('{{pc_site_email}}', [
            'id'             => $this->primaryKey()->unsigned(),
            'site_id'        => $this->integer()->unsigned()->notNull(),
            'sessia'         => $this->integer()->unsigned()->notNull(),
            'unixtimestamp'  => $this->timestamp(),
            'email'          => $this->string()->notNull(), 
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->createTable('{{pc_site_address}}', [
            'id'             => $this->primaryKey()->unsigned(),
            'site_id'        => $this->integer()->unsigned()->notNull(),
            'sessia'         => $this->integer()->unsigned()->notNull(),
            'unixtimestamp'  => $this->timestamp(),
            'address'        => $this->string(1024)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        
        $this->addForeignKey('FK_pc_site_phone_site_id', 
                '{{pc_site_phone}}', 
                'site_id', 
                '{{pc_site}}', 
                'id', 'CASCADE', 'CASCADE');
                
        $this->addForeignKey('FK_pc_site_email_site_id', 
                '{{pc_site_email}}', 
                'site_id', 
                '{{pc_site}}', 
                'id', 'CASCADE', 'CASCADE');
                
        $this->addForeignKey('FK_pc_site_address_site_id', 
                '{{pc_site_address}}', 
                'site_id', 
                '{{pc_site}}', 
                'id', 'CASCADE', 'CASCADE');
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('FK_pc_site_phone_site_id', '{{pc_site_phone}}');
        $this->dropForeignKey('FK_pc_site_email_site_id', '{{pc_site_email}}');
        $this->dropForeignKey('FK_pc_site_address_site_id', '{{pc_site_address}}');
           
        $this->dropTable('{{pc_site}}');
        $this->dropTable('{{pc_site_phone}}');
        $this->dropTable('{{pc_site_email}}');
        $this->dropTable('{{pc_site_address}}');
    } 

}

