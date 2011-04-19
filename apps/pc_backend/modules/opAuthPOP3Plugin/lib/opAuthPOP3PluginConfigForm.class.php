<?php
class opAuthPOP3PluginConfigForm extends sfForm
{
  protected $configs = array(

//s($app['all']['twipne_config']['accesskey'],$app['all']['twipne_config']['secretaccesskey']);
    'pop3_host' => 'opauthpop3plugin_pop3_host',
    'pop3_domain_suffix' => 'opauthpop3plugin_pop3_domain_suffix',
  );
  public function configure()
  {
    $this->setWidgets(array(
      'pop3_host' => new sfWidgetFormInput(),
      'pop3_domain_suffix' => new sfWidgetFormInput(),
    ));
    $this->setValidators(array(
      'pop3_host' => new sfValidatorString(array(),array()),
      'pop3_domain_suffix' => new sfValidatorString(array(),array()),
    ));


    $this->widgetSchema->setHelp('pop3_host', 'POP3 HOST');
    $this->widgetSchema->setHelp('pop3_domain_suffix', 'POP3 DOMAIN SUFFIX');

    foreach($this->configs as $k => $v)
    {
      $config = Doctrine::getTable('SnsConfig')->retrieveByName($v);
      if($config)
      {
        $this->getWidgetSchema()->setDefault($k,$config->getValue());
      }
    }
    $this->getWidgetSchema()->setNameFormat('pop3[%s]');
  }
  public function save()
  {
    foreach($this->getValues() as $k => $v)
    {
      if(!isset($this->configs[$k]))
      {
        continue;
      }
      $config = Doctrine::getTable('SnsConfig')->retrieveByName($this->configs[$k]);
      if(!$config)
      {
        $config = new SnsConfig();
        $config->setName($this->configs[$k]);
      }
      $config->setValue($v);
      $config->save();
    }
  }
  public function validate($validator,$value,$arguments = array())
  {
    return $value;
  }
}

