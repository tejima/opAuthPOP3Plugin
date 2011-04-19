<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opAuthAdapterMailAddress will handle credential for E-mail address.
 *
 * @package    OpenPNE
 * @subpackage lib
 * @author     Mamoru Tejima <tejima@tejimaya.com>
 */
class opAuthAdapterPOP3 extends opAuthAdapter
{
  protected $authModuleName = 'opAuthPOP3';

 /**
  * @see opAuthAdapter::activate()
  */
  public function activate()
  {
    parent::activate();

    $member = sfContext::getInstance()->getUser()->getMember();
    return $member;
  }

  /**
   * Returns true if the current state is a beginning of register.
   *
   * @return bool returns true if the current state is a beginning of register, false otherwise
   */
  public function isRegisterBegin($member_id = null)
  {
    //return false;
    opActivateBehavior::disable();
    $member = Doctrine::getTable('Member')->find((int)$member_id);
    opActivateBehavior::enable();

    if (!$member)
    {
      return false;
    }


    if (!$member->getIsActive())
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * Returns true if the current state is a end of register.
   *
   * @return bool returns true if the current state is a end of register, false otherwise
   */
  public function isRegisterFinish($member_id = null)
  {
    opActivateBehavior::disable();
    $data = Doctrine::getTable('Member')->find((int)$member_id);
    opActivateBehavior::enable();

    if (!$data || !$data->getName() || !$data->getProfiles())
    {
      return false;
    }

    if ($data->getIsActive())
    {
      return false;
    }
    else
    {
      return true;
    }
  }
}
