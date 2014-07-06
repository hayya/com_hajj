<?php
/**
 * @version     1.0.0
 * @package     com_hajj
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Kouceyla Hadji <hadjikouceyla@gmail.com> - http://www.behance.net/kossa
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class HajjControllerHajj extends JControllerLegacy
{

/*
|------------------------------------------------------------------------------------
| Edit Hajj 
|------------------------------------------------------------------------------------
*/
  public function setEditHajj(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj = new stdClass();
    $obj->id_user         = $jinput->get('id_user','','STRING');
    $obj->first_name      = $jinput->get('first_name','','STRING');
    $obj->second_name     = $jinput->get('second_name','','STRING');
    $obj->third_name      = $jinput->get('third_name','','STRING');
    $obj->familly_name    = $jinput->get('familly_name','','STRING');
    $obj->sexe            = $jinput->get('sexe','','STRING');
    $obj->nationality     = $jinput->get('nationality','','STRING');
    $obj->birthday        = $jinput->get('birthday1','','STRING') . '/';
    $obj->birthday       .= $jinput->get('birthday2','','STRING') . '/';
    $obj->birthday       .= $jinput->get('birthday3','','STRING');
    $obj->job             = $jinput->get('job','','STRING');
    $obj->rh              = $jinput->get('rh','','STRING');
    $obj->address         = $jinput->get('address','','STRING');
    $obj->mobile          = $jinput->get('mobile','','STRING');
    $obj->email           = $jinput->get('email','','STRING');
    $obj->office_branch   = $jinput->get('office_branch','','STRING');
    $obj->hajj_program    = $jinput->get('hajj_program','','STRING');
    $obj->register_status = $jinput->get('register_status','','STRING');

    $this->getModel('Hajj')->setEditHajj($obj);
    if (is_null($obj->register_status)) {
      $redirect = "index.php?option=com_hajj&view=edithajj";
    }else{
      $redirect = "index.php?option=com_hajj&task=admin.hajjs";
    }
    $app->redirect($redirect, 
      "تم التعديل بنجاح",
      'success');
  }

/*
|------------------------------------------------------------------------------------
| Remove Hajj
|------------------------------------------------------------------------------------
*/
  public function removeHajj(){
    
    $app = JFactory::getApplication();
    $id = JFactory::getUser()->id;
    $lol = $this->getModel('Hajj')->removeHajj($id);
    

    $app->redirect("index.php", 
      "تم التعديل بنجاح",
      'success');
    
  }

}