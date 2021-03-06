<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseDonation extends sfDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('donation');
    $this->hasColumn('bundler_id', 'integer', null, array('type' => 'integer'));

    $this->option('collate', 'utf8_unicode_ci');
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    $this->hasOne('Entity as Bundler', array('local' => 'bundler_id',
                                             'foreign' => 'id',
                                             'onDelete' => 'SET NULL',
                                             'onUpdate' => 'CASCADE'));

    $this->hasMany('Relationship', array('local' => 'relationship_id',
                                         'foreign' => 'id'));

    $relationshipcategorytemplate0 = new RelationshipCategoryTemplate();
    $this->actAs($relationshipcategorytemplate0);
  }
}