<?php
class opAuthLoginFormPOP3 extends opAuthLoginForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'id' => new sfWidgetFormInput(),
      'password' => new sfWidgetFormInputPassword(),
    ));

    $this->setValidatorSchema(new sfValidatorSchema(array(
      'id' => new sfValidatorString(),
      'password' => new sfValidatorString(),
    )));

  $this->widgetSchema->setHelp('id', '@'.opConfig::get('opauthpop3plugin_pop3_domain_suffix'));

	$this->mergePostValidator(
	new opAuthValidatorPOP3()
	);
    parent::configure();
  }
}
