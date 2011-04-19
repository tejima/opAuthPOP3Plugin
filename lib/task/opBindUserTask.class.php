<?php
class opBindUserTask extends sfBaseTask
{
  protected function configure()
  {
    #set_time_limit(120);
    mb_language("Japanese");
    mb_internal_encoding("utf-8");

    $this->namespace        = 'zuniv.us';
    $this->name             = 'bindUser';
    $this->briefDescription = 'bind user for pop3';
    $this->detailedDescription = <<<EOF
EOF;
    $this->addOption('application',null, sfCommandOption::PARAMETER_REQUIRED, 'The application name','pc_frontend');
    $this->addOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod');
    $this->addArgument('id', sfCommandArgument::REQUIRED, 'id');
    $this->addArgument('name', sfCommandArgument::REQUIRED, 'name');
    $this->addArgument('value', sfCommandArgument::REQUIRED, 'value');
  }
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    print_r($arguments);
    $member =  Doctrine::getTable('Member')->find($arguments['id']);
    $member->setConfig($arguments['name'],$arguments['value']);
    $member->save();
  }
}
