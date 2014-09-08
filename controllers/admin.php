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

class HajjControllerAdmin extends JControllerLegacy
{

  /*
    08 -> Super Users
    10 -> HajjAdmin
    11 -> HajjFinance
    12 -> HajjManager
  */
  private $allowedGroup = array(8,10,11,12);
  private $group;
  private $user_id;

/*
|------------------------------------------------------------------------------------
| Change the construct
|------------------------------------------------------------------------------------
*/
  public function __construct(){
   
    $this->user_id = JFactory::getUser()->id;
    $this->group   = JAccess::getGroupsByUser($this->user_id, false)[0];

    if(!is_numeric(array_search($this->group,$this->allowedGroup))){
      return JError::raiseWarning(404, "JText::_('JERROR_ALERTNOAUTHOR')");
    }
   
    parent::__construct();
  }

/*
|------------------------------------------------------------------------------------
| Get List of hajjs
|------------------------------------------------------------------------------------
*/
  public function Hajjs(){


    $jinput = JFactory::getApplication()->input;
    $offset = $jinput->get('p','1');

    // Filters
    $register_status = $jinput->get('register_status','', 'STRING');
    $office_branch   = $jinput->get('office_branch','', 'STRING');
    $hajj_program    = $jinput->get('hajj_program','', 'STRING');
    $sexe            = $jinput->get('sexe','', 'STRING');
    $deny            = $jinput->get('deny','', 'STRING');
    $Itemid          = $jinput->get('Itemid','', 'STRING');
    
    
    if ($deny != '') {// We display deny Hajjs
      $where = 'register_status = 3 OR register_status = 5';
    }else{// We display activated Hajjs
      $where = 'register_status != 3 AND register_status != 5';
    }
    
    if ($this->group == 12) { // This is a Manager
      $personnelsModel = $this->getModel("Personnels"); // Get the model
      $office_branch   = $personnelsModel->getPersonnels('id_user = '.$this->user_id)[0]->office_branch; // Get the branch
      $where          .= ' AND office_branch = ' . $office_branch; // Set the branch for the select
    }

    $where .= ($register_status!='') ? ' AND register_status = '.$register_status: '';
    $where .= ($office_branch!='') ? ' AND office_branch = '.$office_branch: '';
    $where .= ($hajj_program!='') ? ' AND hajj_program = '.$hajj_program: '';
    $where .= ($sexe!='') ? ' AND sexe = "'.$sexe.'"': '';

    // Pagination
    $limit   = 20;
    $start   = ($offset - 1) * $limit ;
    
    $model   = $this->getModel("Admin");
    // Update all empty register status
    $model->updateEmptyStatus();
    $result  = $model->getHajjs($start, $limit,$where);
    $nbHajjs = $model->getNbHajjs($where);
    
    $view    = $this->getView('adminhajjs', 'html'); //get the view
    $view->assignRef('data', $result); // assign data from the model
    $view->assignRef('start', $offset); // assign data from the model
    $view->assignRef('nbHajjs', $nbHajjs); // assign data from the model

    $view->assignRef('register_status', $register_status); // assign data from the model
    $view->assignRef('office_branch', $office_branch); // assign data from the model
    $view->assignRef('hajj_program', $hajj_program); // assign data from the model
    $view->assignRef('sexe', $sexe); // assign data from the model
    $view->assignRef('deny', $deny); // assign data from the model
    $view->assignRef('Itemid', $Itemid); // assign data from the model

    $view->display(); // display the view
  }

/*
|------------------------------------------------------------------------------------
| Get only one Hajj
|------------------------------------------------------------------------------------
*/
  public function Hajj(){
    $jinput = JFactory::getApplication()->input;

    $id = $jinput->get('id','','STRING');

    $result = $this->getModel("Admin")->getHajj($id);

    $view   = $this->getView('adminhajj', 'html'); //get the view
    $view->assignRef('data', $result); // assign data from the model
    $view->display(); // display the view
  }

/*
|------------------------------------------------------------------------------------
| Get SMS status
|------------------------------------------------------------------------------------
*/
  public function Sms(){

    $jinput = JFactory::getApplication()->input;
    $offset = $jinput->get('p','1');

    // Pagination
    $limit   = 20;
    $start   = ($offset - 1) * $limit ;

    $model =$this->getModel("Admin");
    $result = $model->getSMS($start, $limit);
    $nbSMS = $model->getNbSMS();

    $view   = $this->getView('adminsms', 'html'); //get the view
    $view->assignRef('data', $result); // assign data from the model
    $view->assignRef('start', $start); // assign data from the model
    $view->assignRef('nbSMS', $nbSMS); // assign data from the model
    
    $view->display(); // display the view

  }

/*
|------------------------------------------------------------------------------------
| Admin Remove Hajj
|------------------------------------------------------------------------------------
*/
  public function removeHajj(){

    $app = JFactory::getApplication();
    $id = $app->input->get('id','','STRING');
    $hajj = $this->getModel("admin")->getHajj($id);

    $mobile  = $hajj->mobile;
    $id_user = $hajj->id_user;

    $result  = $this->getModel("hajj")->removeHajj($id_user, TRUE); // True for Admin

    // msgcode = تم إلغاء طلب حجزكم. شركة فوج مكة لحجاج الداخل تتمنى لكم حجا مقبولا وسعيا مشكورا ويسعدنا تسجيلكم معنا مرة أخرى.
    require_once JPATH_COMPONENT.'/helpers/' .'hajj.php';
    $msgcode = "062A0645002006250644063A0627062100200637064406280020062D062C063206430645002E00200634063106430629002006410648062C002006450643062900200644062D062C0627062C002006270644062F0627062E06440020062A062A06450646064900200644064306450020062D062C062700200645064206280648064406270020064806330639064A0627002006450634064306480631062700200648064A06330639062F064606270020062A0633062C064A06440643064500200645063906460627002006450631062900200623062E06310649002E";
    HajjFrontendHelper::sendTheSMS($mobile, $msgcode);

    $txt = "تم حذف الحجز رقم: " . $id ." بنجاح";
    $app->redirect("index.php?option=com_hajj&task=admin.hajjs", $txt, "success");

  }

/*
|------------------------------------------------------------------------------------
| Admin set Program
|------------------------------------------------------------------------------------
*/
  public function setProgram(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj = new stdClass();
    $obj->id = $jinput->get('id','','STRING');
    $obj->name = $jinput->get('name','','STRING');
    $obj->price_program = $jinput->get('price_program','','STRING');
    $obj->status = $jinput->get('status','','STRING');

    if ($obj->id != "") { // Edit
      $this->getModel('admin')->setEditProgram($obj);
    }else{ // New Program
      $this->getModel('admin')->setProgram($obj);
    }

    
    $app->redirect('index.php?option=com_hajj&view=adminPrograms', 'تم حفظ البيانات بنجاح', 'success');
  }

/*
|------------------------------------------------------------------------------------
| Admin set Personnel
|------------------------------------------------------------------------------------
*/
  public function setPersonnel(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $user                     = new stdClass();
    $personnel                = new stdClass();
    $personnel->id            = $jinput->get('id','','STRING');
    $personnel->office_branch = $jinput->get('office_branch','','STRING');
    $personnel->authority     = $jinput->get('authority','','STRING');
    $personnel->phone         = $jinput->get('phone','','STRING');
    
    $user->email              = $jinput->get('email','','STRING');
    $user->name               = $jinput->get('name','','STRING');
    $user->password1          = $jinput->get('password1','','STRING');
    $user->password2          = $jinput->get('password2','','STRING');
    $user->username           = $jinput->get('username','','STRING');
    
    $url = 'index.php?option=com_hajj&view=adminPersonnel&Itemid=290';

    // Check same password 
    if ($user->password1 != $user->password2) {
      $app->redirect($url, 'يرجى وضع نفس كلمة السر', 'error');
    }

    
    if ($personnel->id != "") { // Edit
      $this->getModel('personnels')->editPersonnel($personnel);
    }else{ // New Personnel
      
      // Save the user in Joomla user
      require_once JPATH_COMPONENT.'/helpers/' .'hajj.php';
      $personnel->id_user = HajjFrontendHelper::register_user($user->username, $user->password1,$user->password1, $user->email, $user->name, array($personnel->authority));
      $this->getModel('personnels')->setPersonnel($personnel);
    }

    $app->redirect($url, 'تم حفظ البيانات بنجاح', 'success');
  }


/*
|------------------------------------------------------------------------------------
| Admin set Tents
|------------------------------------------------------------------------------------
*/
  public function setTents(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj = new stdClass();
    $obj->id = $jinput->get('id','','STRING');
    $obj->name = $jinput->get('name','','STRING');
    $obj->hajj_program = $jinput->get('hajj_program','','STRING');
    $obj->sexe = $jinput->get('sexe','','STRING');
    $obj->nb_family = $jinput->get('nb_family','','STRING');
    $obj->status = $jinput->get('status','','STRING');

    if ($obj->id != "") { // Edit
      $this->getModel('tents')->EditTents($obj);
    }else{ // New Tents
      $this->getModel('tents')->setTents($obj);
    }

    
    $app->redirect('index.php?option=com_hajj&view=adminTents', 'تم حفظ البيانات بنجاح', 'success');
  }

/*
|------------------------------------------------------------------------------------
| Admin set Camps
|------------------------------------------------------------------------------------
*/
  public function setCamps(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj = new stdClass();
    $obj->id = $jinput->get('id','','STRING');
    $obj->group = $jinput->get('group','','STRING');
    $obj->box = $jinput->get('box','','STRING');
    $obj->camp = $jinput->get('camp','','STRING');
    $obj->site = $jinput->get('site','','STRING');
    $obj->coordinates = $jinput->get('coordinates','','STRING');
    $obj->status = $jinput->get('status','','STRING');
    

    if ($obj->id != "") { // Edit
      $this->getModel('admin')->setEditCamps($obj);
    }else{ // New Camps
      $this->getModel('admin')->setCamps($obj);
    }

    
    $app->redirect('index.php?option=com_hajj&view=adminCamps', 'تم حفظ المخيم بنجاح', 'success');
  }


/*
|------------------------------------------------------------------------------------
| Admin set Program
|------------------------------------------------------------------------------------
*/
  public function setBranch(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj = new stdClass();
    $obj->id = $jinput->get('id','','STRING');
    $obj->name = $jinput->get('name','','STRING');
    $obj->status = $jinput->get('status','','STRING');

    if ($obj->id != "") { // Edit
      $this->getModel('admin')->setEditBranch($obj);
    }else{ // New Branch
      $this->getModel('admin')->setBranch($obj);
    }
    
    $app->redirect('index.php?option=com_hajj&view=adminBranchs', 'تم حفظ البيانات بنجاح', 'success');
  }

/*
|------------------------------------------------------------------------------------
| Admin set Program
|------------------------------------------------------------------------------------
*/
  public function benefits(){
    
    require_once JPATH_COMPONENT . '/helpers/hajj.php';
    HajjFrontendHelper::updateHajjsPayment();

    
    $jinput = JFactory::getApplication()->input;
    $offset = $jinput->get('p','1');

    // Filters
    $id_hajj         = $jinput->get('id_hajj','', 'STRING');
    $hajj_program    = $jinput->get('hajj_program','', 'STRING');
    $current_payment = $jinput->get('current_payment','', 'STRING');
    $status_addon    = $jinput->get('status_addon','', 'STRING');
    $Itemid          = $jinput->get('Itemid','', 'STRING');

    // Pagination
    $limit  = 20;
    $start  = ($offset - 1) * $limit ;
    
    // Construct the WHERE
    $where='1=1';
    // For the ACL
    if ($this->group == 12) { // This is a Manager
      $personnelsModel = $this->getModel("Personnels"); // Get the model
      $office_branch   = $personnelsModel->getPersonnels('id_user = '.$this->user_id)[0]->office_branch; // Get the branch
      $where           = ' HU.office_branch = ' . $office_branch; // Set the branch for the select
    }

    $where .= ($id_hajj != '') ? ' AND HU.id = '.$id_hajj: '';
    $where .= ($hajj_program != '') ? ' AND HP.id = '.$hajj_program: '';
    if ($current_payment != '') {
      switch ($current_payment) {
        case '0': //لا يوجد مبلغ مطلوب
          $where .= ' AND HU.topay = 0';
          break;
        
        case '1': //لم يتم الدفع
          $where .= ' AND HU.paid = 0';
          break;
        
        case '2': //دفع جزئي
          $where .= ' AND HU.topay > 0 AND  HU.paid > 0';
          break;
        
        default:
          # code...
          break;
      }
    }

    $having = '';
    if ($status_addon != '') {
      switch ($status_addon) {
        case '0':
          $having = 'COUNT(fils.id)=0';
          break;
        
        case '1':
          $having = 'COUNT(fils.id)>0';
          break;
        
        default:
          # code...
          break;
      }
    }

    $model  = $this->getModel("Admin");
    $result = $model->getBenefits($start, $limit,$where, $having);
    
    $view   = $this->getView('adminbenefits', 'html'); //get the view
    $view->assignRef('data', $result); // assign data from the model
    $view->assignRef('id_hajj', $id_hajj); // assign data from the model
    $view->assignRef('hajj_program', $hajj_program); // assign data from the model
    $view->assignRef('current_payment', $current_payment); // assign data from the model
    $view->assignRef('status_addon', $status_addon); // assign data from the model
    $view->assignRef('start', $offset); // assign data from the model
    $view->assignRef('nbBenefits', $result->nbRows); // assign data from the model

    $view->display(); // display the view
  }

/*
|------------------------------------------------------------------------------------
| set Admin Information
|------------------------------------------------------------------------------------
*/
  public function setAdminInfo(){

    $app = JFactory::getApplication();
    $jinput = $app->input;

    $txt                      = new stdClass();
    $txt->name                = $jinput->get('name','','STRING');
    $txt->commercial_register = $jinput->get('commercial_register','','STRING');
    $txt->address             = $jinput->get('address','','STRING');
    $txt->email               = $jinput->get('email','','STRING');
    $txt->tel                 = $jinput->get('tel','','STRING');
    $txt->fax                 = $jinput->get('fax','','STRING');
    $txt->mobile              = $jinput->get('mobile','','STRING');
    $txt->logo                = $jinput->get('logo','','STRING');

    $obj        = new stdClass();
    $obj->name  = "adminInfo";
    $obj->value = json_encode($txt);

    $this->getModel('admin')->setAdminInfo($obj);

    $app->redirect('index.php?option=com_hajj&view=administration', 'تم حفظ الإدارة العامة بنجاح', 'success');
  }

/*
|------------------------------------------------------------------------------------
| set Register Status
|------------------------------------------------------------------------------------
*/
  public function setRegisterStatus(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj        = new stdClass();
    $obj->name  = "register_status";
    $obj->value = $jinput->get("status", 0);

    $this->getModel('admin')->setAdminRegisterStatus($obj);

    $app->redirect('index.php?option=com_hajj&view=adminregisterstatus', 'تم حفظ حالة الحجز بنجاح', 'success');
  }


/*
|------------------------------------------------------------------------------------
| set Combine Addons
|------------------------------------------------------------------------------------
*/
  public function setCombineAddons(){
    $app = JFactory::getApplication();
    $jinput = $app->input;

    $obj           = new stdClass();
    $obj->original = $jinput->get("original", '', 'STRING');
    $addons        = $jinput->get("addons",  '', 'ARRAY');
    $obj->addons   = implode(', ', $addons);

    if($this->getModel('admin')->setCombineAddons($obj)){
      $app->redirect('index.php?option=com_hajj&view=admincombineaddons', 'تم  تعديل المرافقين بنجاح', 'success');
    }else{
      $app->redirect('index.php?option=com_hajj&view=admincombineaddons', 'خطأ SQL', 'error');
    }
  }



/*
|------------------------------------------------------------------------------------
| Get the attachment for payment in case of Admine
|------------------------------------------------------------------------------------
*/
  public function getImgPayment(){
    $app     = JFactory::getApplication();
    $jinput  = $app->input;
    $imgName = $jinput->get("img");
    header('Content-Type: image/jpeg');
    readfile(JPATH_SITE.'/media/com_hajj/upload/' . $imgName);
    exit;
  }


/*
|------------------------------------------------------------------------------------
| Get the attachment for payment in case of Admine
|------------------------------------------------------------------------------------
*/
  public function setTransferStatus(){
    $app                  = JFactory::getApplication();
    $jinput               = $app->input;
    
    $obj                  = new stdClass();
    $obj->transfer_status = $jinput->get("transfer_status", 0);
    $id                   = $jinput->get("id",  '', 'ARRAY');
    $obj->id              = implode(', ', $id);
    
    if($this->getModel('admin')->setTransferStatus($obj)){
      $app->redirect('index.php?option=com_hajj&task=admin.hajjs', 'تم  تعديل التحويل بنجاح', 'success');
    }else{
      $app->redirect('index.php?option=com_hajj&task=admin.hajjs', 'خطأ SQL', 'error');
    }
  }

/*
|------------------------------------------------------------------------------------
| Update the status to tama daf3
|------------------------------------------------------------------------------------
*/
  public function setTamaDaf3(){
    $app                  = JFactory::getApplication();
    $jinput               = $app->input;
    
    $obj                  = new stdClass();
    $obj->id              = $jinput->get('idHajj', 0);
    $obj->register_status = 6; // الرفع للوزارة
    if (!$obj->id) {
      $app->redirect('index.php?option=com_hajj&view=paymentmade&Itemid=295', 'Error', 'Danger');
    }

    $model = $this->getModel('hajj');
    
    // Get the Mobile of Hajj
    $mobile = $model->getMobile($obj->id);

    // Send the SMS
    $obj->sms6 = "نأمل منكم رفع المستندات المطلوبة عن طريق خدماتنا الإلكترونية. لمعرفة المستندات المطلوبة فضلا راجع خدمات التسجيل.";
    $msgcode = "064606230645064400200645064606430645002006310641063900200627064406450633062A0646062F0627062A002006270644064506370644064806280629002006390646002006370631064A06420020062E062F06450627062A06460627002006270644062506440643062A063106480646064A0629002E002006440645063906310641062900200627064406450633062A0646062F0627062A00200627064406450637064406480628062900200641063606440627002006310627062C06390020062E062F06450627062A002006270644062A0633062C064A0644002E000A";
    if($model->setTamaDaf3($obj)){
      require_once JPATH_COMPONENT.'/helpers/' .'hajj.php';
      HajjFrontendHelper::sendTheSMS($mobile, $msgcode);
    }

    $msg = 'تم رفع الحجز رقم : ' . $obj->id . ' للوزارة';
    $app->redirect('index.php?option=com_hajj&view=paymentmade&Itemid=295', $msg, 'success');
  }

}