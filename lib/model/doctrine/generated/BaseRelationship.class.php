<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseRelationship extends sfDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('relationship');
    $this->hasColumn('entity1_id', 'integer', null, array('type' => 'integer', 'notnull' => true));
    $this->hasColumn('entity2_id', 'integer', null, array('type' => 'integer', 'notnull' => true));
    $this->hasColumn('category_id', 'integer', null, array('type' => 'integer', 'notnull' => true));
    $this->hasColumn('description1', 'string', 200, array('type' => 'string', 'length' => '200'));
    $this->hasColumn('description2', 'string', 200, array('type' => 'string', 'length' => '200'));
    $this->hasColumn('amount', 'integer', null, array('type' => 'integer'));
    $this->hasColumn('goods', 'clob', null, array('type' => 'clob'));
    $this->hasColumn('filings', 'integer', null, array('type' => 'integer'));
    $this->hasColumn('notes', 'clob', null, array('type' => 'clob'));

    $this->option('collate', 'utf8_unicode_ci');
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    $this->hasOne('Entity as Entity1', array('local' => 'entity1_id',
                                             'foreign' => 'id',
                                             'onDelete' => 'CASCADE',
                                             'onUpdate' => 'CASCADE'));

    $this->hasOne('Entity as Entity2', array('local' => 'entity2_id',
                                             'foreign' => 'id',
                                             'onDelete' => 'CASCADE',
                                             'onUpdate' => 'CASCADE'));

    $this->hasOne('RelationshipCategory as Category', array('local' => 'category_id',
                                                            'foreign' => 'id',
                                                            'onUpdate' => 'CASCADE'));

    $this->hasOne('Position', array('local' => 'id',
                                    'foreign' => 'relationship_id'));

    $this->hasOne('Education', array('local' => 'id',
                                     'foreign' => 'relationship_id'));

    $this->hasOne('Membership', array('local' => 'id',
                                      'foreign' => 'relationship_id'));

    $this->hasOne('Family', array('local' => 'id',
                                  'foreign' => 'relationship_id'));

    $this->hasOne('Donation', array('local' => 'id',
                                    'foreign' => 'relationship_id'));

    $this->hasOne('Transaction', array('local' => 'id',
                                       'foreign' => 'relationship_id'));

    $this->hasOne('Lobbying', array('local' => 'id',
                                    'foreign' => 'relationship_id'));

    $this->hasOne('Ownership', array('local' => 'id',
                                     'foreign' => 'relationship_id'));

    $this->hasMany('LobbyFiling', array('refClass' => 'LobbyFilingRelationship',
                                        'local' => 'relationship_id',
                                        'foreign' => 'lobby_filing_id'));

    $this->hasOne('Link', array('local' => 'id',
                                'foreign' => 'relationship_id'));

    $this->hasMany('Reference', array('local' => 'id',
                                      'foreign' => 'object_id'));

    $this->hasMany('FecFiling', array('local' => 'id',
                                      'foreign' => 'relationship_id'));

    $this->hasMany('FedspendingFiling', array('local' => 'id',
                                              'foreign' => 'relationship_id'));

    $this->hasMany('LobbyFilingRelationship', array('local' => 'id',
                                                    'foreign' => 'relationship_id'));

    $timestampable0 = new Doctrine_Template_Timestampable();
    $dateable0 = new Dateable();
    $lsversionable0 = new LsVersionable();
    $referenceable0 = new Referenceable();
    $softdelete0 = new Doctrine_Template_SoftDelete(array('name' => 'is_deleted'));
    $customizable0 = new Customizable();
    $this->actAs($timestampable0);
    $this->actAs($dateable0);
    $this->actAs($lsversionable0);
    $this->actAs($referenceable0);
    $this->actAs($softdelete0);
    $this->actAs($customizable0);
  }
}