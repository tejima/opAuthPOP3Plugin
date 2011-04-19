<?php

/**
 * opSheetSyncPlugin actions.
 *
 * @package    OpenPNE
 * @subpackage opSheetSyncPlugin
 * @author     Your name here
 */
class opAuthPOP3PluginActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new opAuthPOP3PluginConfigForm();
    if ($request->isMethod(sfWebRequest::POST))
    {
      $this->form->bind($request->getParameter('pop3'));
      if ($this->form->isValid())
      {
        $this->form->save();
        $this->redirect('opAuthPOP3Plugin/index');
      }
    }

  }
}

