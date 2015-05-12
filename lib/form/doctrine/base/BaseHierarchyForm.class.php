<?php

/**
 * Hierarchy form base class.
 *
 * @package    form
 * @subpackage hierarchy
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseHierarchyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'relationship_id' => new sfWidgetFormDoctrineSelect(array('model' => 'Relationship', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => 'Hierarchy', 'column' => 'id', 'required' => false)),
      'relationship_id' => new sfValidatorDoctrineChoice(array('model' => 'Relationship')),
    ));

    $this->widgetSchema->setNameFormat('hierarchy[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Hierarchy';
  }

}