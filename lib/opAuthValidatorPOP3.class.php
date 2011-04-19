<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opAuthValidatorPOP3
 *
 * @package    OpenPNE
 * @subpackage validator
 * @author     Mamoru Tejima <tejima@tejimaya.com>
 */
class opAuthValidatorPOP3 extends sfValidatorSchema
{
  /**
   * Constructor.
   *
   * @param array  $options   An array of options
   * @param array  $messages  An array of error messages
   *
   * @see sfValidatorSchema
   */
  public function __construct($options = array(), $messages = array())
  {
    parent::__construct(null, $options, $messages);
  }

  /**
   * Configures this validator.
   *
   * Available options:
   *
   *  * config_name: The configuration name of MemberConfig
   *
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'ID is not a valid.');
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {
    opActivateBehavior::disable();
    $user = $values['id'] . "@" . opConfig::get('opauthpop3plugin_pop3_domain_suffix',null);

    $param = array('host' => opConfig::get('opauthpop3plugin_pop3_host',null),
               'user' => $user,
               'password' => $values['password'],
               'port' => 995,
               'ssl'  => 'SSL');


    try{
      $mail = new Zend_Mail_Storage_Pop3($param);
    }catch(Zend_Mail_Protocol_Exception $e){
      die();
      throw new sfValidatorError($this, 'invalid');
      
    }

    $memberConfig = Doctrine::getTable('MemberConfig')->retrieveByNameAndValue('pop3', $user);
    if ($memberConfig)
    {
      $values['member'] = $memberConfig->getMember();
    }else{ //create new member
      /*
      $context = sfContext::getInstance();
      $member = $context->getUser()->getMember(true);
      if (!$member || !$member->getId())
      {
        $member = Doctrine::getTable('Member')->createPre();
        $member->generateRegisterToken();
      }
      */
      $member = new Member();
      $member->is_active = 1;
      $member->name = $user;
      $member->save();
      $member->setConfig('pop3', $user);
      $member->setConfig('pc_address', $user);
      $password =  base_convert( rand(10e16, 10e20),10, 36);

      $member->setConfig('password', md5($values['password']));
      $member->save();
      $values['member'] = $member;
    }

    opActivateBehavior::enable();
    return $values;
  }
}
