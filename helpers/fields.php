<?php

/**
 * @version     1.0.0
 * @package     com_hajj
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Kouceyla Hadji <hadjikouceyla@gmail.com> - http://www.behance.net/kossa
 */
defined('_JEXEC') or die;

class HajjFieldHelper {

    public static $Nationnality     = array("سعودي", "مصري", "أمريكي", "باكستاني  ", "هندي", "أردني", "سوداني", "سوري", "أرجنتيني", "أسباني", "إسترالي", "أفغانستاني", "ألماني", "إماراتي", "اندونيسي", "ايطالي", "بحريني", "برازيلي", "بريطاني", "بنجلاديشي", "تركي", "تونسي", "جزائري", "جنوب أفريقي", "سنغافوري", "سويسري", "سيريلانكي", "صومالي", "صيني", "عراقي", "فرنسي", "فلسطيني", "فليبيني", "فيتنامي", "قطري", "كاميروني", "كندي", "كويتي", "لبناني", "ماليزي", "نيجيري", "نيوزلندي", "ياباني", "يمني", "يوناني", "كويتي بدون", "أزربيجان", "مغربي", "أخري");
    public static $Months           = array("محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأول", "جمادى الآخر", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
    public static $RHS              = array("O+", "O-", "A+", "A-", "B+", "B-", "AB+", "AB-");
    public static $hajjProgram      = array("برنامج الفرسان", "برنامج التميز", "برنامج الوسام", "برنامج الصفوة");
    public static $officeBranch     = array("مكة المكرمة", "المدينة المنورة", "جدة");
    public static $status_hajjs     = array("تحت التدقيق والمراجعة", "مقبول", "مرفوض", "تم الدفع", "الغاء الحجز");
    public static $reason_exception = array("محرم", "طبيب", "عصبة نساء", "مع محرمها", "اداري", "عامل في الحملة", "ممرضة", "حج عن متوفي");
    public static $account_owner    = array("مصرف الراجحي", "بنك البلاد", "البنك الأهلي");
    public static $status_payment   = array("تحت التدقيق", "مقبولة", "مرفوضة");
    public static $sexe             = array("رجال", "نساء");
    public static $status_tents      = array("مقفل", "شاغر");

/*
|------------------------------------------------------------------------------------
| Get list of Programs
|------------------------------------------------------------------------------------
*/
  public static function getPrograms($is_admin=false){
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);
    $query
        ->select($db->quoteName(array('id', 'name')))
        ->from($db->quoteName('#__hajj_program'));
    if (!$is_admin) {
      $query->where('status=1');
    }    
    
    $db->setQuery($query);
    $results = $db->loadObjectList();
    
    return ($results);
  } 


/*
|------------------------------------------------------------------------------------
| Get list of Branchs
|------------------------------------------------------------------------------------
*/
  public static function getBranchs($is_admin=false){
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);
    $query
        ->select($db->quoteName(array('id', 'name')))
        ->from($db->quoteName('#__hajj_branch'));
    if (!$is_admin) {
      $query->where('status=1');
    }
    
    $db->setQuery($query);
    $results = $db->loadObjectList();
    
    return ($results);
  } 

/*
|------------------------------------------------------------------------------------
| Get list of Nation
|------------------------------------------------------------------------------------
*/
  public static function getListNationnality($active = ""){ 
    //var_dump(self::$Nationnality);
    ?>
      <select name="nationality" id="nationality" required>
        <option value=""></option>
        <?php foreach (self::$Nationnality as $key => $value): ?>
            <option <?php echo ($active == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>"><?php echo $value ?></option>
        <?php endforeach ?>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get Nationnality
|------------------------------------------------------------------------------------
*/
  public static function getNationnality($id){
    $id = (int)$id;
    return self::$Nationnality[$id-1];
  }

/*
|------------------------------------------------------------------------------------
| Get Birthday fields
|------------------------------------------------------------------------------------
*/
  public static function getBirthday($active = ""){
        
      if ($active == "") {
          $date = $month = $year = "";
      }else{
          list($date, $month, $year) = explode("/", $active);            
      }
      ?>
      <select class="span4" name="birthday1" id="birthday" required> 
        <option value="">اليوم </option>
        <?php for ($i=1; $i < 31; $i++) :?>
            <option <?php echo ($date == $i) ? "selected" : "" ?> value="<?php echo $i ?>"><?php echo $i ?></option> 
        <?php endfor ?>
      </select>

      <select class="span4" name="birthday2">
        <option <?php echo ($month == "") ? "selected"  : "" ?> value="0">الشهر</option>
          <?php foreach (self::$Months as $key => $value): ?>
              <option <?php echo ($month == $key+1) ? "selected"  : "" ?> value="<?php echo $key+1 ?>"><?php echo $value ?></option>
          <?php endforeach ?>
      </select>

      <select class="span4" name="birthday3">
        <option value="">السنه</option>
        <?php for ($i=1435; $i > 1330; $i--) : ?>
            <option <?php echo ($year == $i) ? "selected" : "" ?> value="<?php echo $i ?>"><?php echo $i ?></option>
        <?php endfor ?>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get RH List
|------------------------------------------------------------------------------------
*/
  public static function getRH($active = ""){
    ?>
      <select name="rh" id="rh">
        <option value=""></option>
        <?php foreach (self::$RHS as $key => $rh): ?>
          <option <?php echo ($active == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>"><?php echo $rh ?></option>
        <?php endforeach ?>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get Hajj Program
|------------------------------------------------------------------------------------
*/
  public static function getHajjProgram($active = "", $is_admin=false, $is_addon=false){    

    ?>
      <select name="hajj_program" id="hajj_program" required <?php echo ($is_addon)? 'disabled':'' ?>>
        <option value=""></option>
        <?php foreach (self::getPrograms($is_admin) as $key => $value): ?>
          <option <?php echo ($active == $value->id) ? "selected" : "" ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
        <?php endforeach ?>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get Hajj Program List
|------------------------------------------------------------------------------------
*/
  public static function getHajjProgramList($is_admin=false){    
      $array = array();
      foreach (self::getPrograms($is_admin) as $key => $value){
        $array[$value->id] = $value->name;
      }

      return($array);
  }

/*
|------------------------------------------------------------------------------------
|  Get Office Branch
|------------------------------------------------------------------------------------
*/
  public static function GetOfficeBranch($active = "", $is_admin=false, $is_addon=false){
    ?>
      <select name="office_branch" id="office_branch" required <?php echo ($is_addon)? 'disabled':'' ?>>
        <option value=""></option>
        <?php foreach (self::getBranchs($is_admin) as $key => $value): ?>
          <option <?php echo ($active == $value->id) ? "selected" : "" ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
        <?php endforeach ?>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get Office Branch List
|------------------------------------------------------------------------------------
*/
  public static function getHajjOfficeBranchList($is_admin=false){    
      $array = array();
      foreach (self::getBranchs($is_admin) as $key => $value){
        $array[$value->id] = $value->name;
      }

      return($array);
  }

/*
|------------------------------------------------------------------------------------
|  Get Office sexe
|------------------------------------------------------------------------------------
*/
  public static function Getsexe($active = ""){
    ?>
      <select name="sexe" id="sexe" required>
        <option></option>
        <option <?php echo ($active == "m") ? "selected" : "" ?> value="m">ذكر</option>
        <option <?php echo ($active == "f") ? "selected" : "" ?> value="f">انثى</option>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get the Form of Hajj register
|------------------------------------------------------------------------------------
*/
  public static function getFormHajj($addon = false, $hajj=""){
    if ($addon) {// if addon we retrieve the branch + program
      $office_branch = self::$officeBranch[$hajj->office_branch-1];
      $hajj_program  = self::$hajjProgram[$hajj->hajj_program-1];
    }
    ?>
      <form action="index.php?option=com_hajj&task=public.setnewhajj" method="post" accept-charset="utf-8">
        <div class="row-fluid">
          <div class="span4">
            <label for="third_name">الاسم الثالث</label>
            <input type="text" name="third_name" id="third_name" required>
          </div>
          <div class="span4">
            <label for="second_name">الاسم الثاني</label>
            <input type="text" name="second_name" id="second_name" required>
          </div>
          <div class="span4">
            <label for="first_name">الاسم الاول</label>
            <input type="text" name="first_name" id="first_name" required>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="nationality">الجنسية</label>
            <?php self::getListNationnality() ?>
          </div>
          <div class="span4">
            <label for="sexe">الجنس</label>
            <select name="sexe" id="sexe" required>
              <option></option>
              <option value="m">ذكر</option>
              <option value="f">انثى</option>
            </select>
          </div>
          <div class="span4">
            <label for="familly_name">العائلة</label>
            <input type="text" name="familly_name" id="familly_name" required>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="id_number">رقم الهوية / الإقامة</label>
            <input type="text" name="id_number" id="id_number" required pattern="[0-9]{10}|[١-٩]{10}" placeholder="يجب أن يكون عشرة أرقام">
          </div>
          <div class="span4">
            <label for="birthday">تاريخ الميلاد</label>
            <?php self::getBirthday() ?>
          </div>
          <div class="span4">
            <label for="job">الوظيفة</label>
            <input type="text" name="job" id="job" required>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="rh">فصيلة الدم</label>
            <?php self::getRH() ?>
          </div>
          <div class="span4">
            <label for="address">العنوان</label>
            <input type="text" name="address" id="address" required>
          </div>
          <div class="span4">
            <label for="mobile">الجوال</label>
            <input type="text" name="mobile" id="mobile" required placeholder="05xxxxxxxx" pattern="05[0-9]{8}">
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="email">البريد الالكتروني</label>
            <input type="text" name="email" id="email">
          </div>
          <div class="span4">
            <label for="office_branch">فرع التسجيل</label>
            <?php if ($addon): // an addon?>
              <select name="office_branch">
                <option value="<?php echo $hajj->office_branch ?>"><?php echo $office_branch ?></option>
              </select>
            <?php else: ?>
              <?php self::GetOfficeBranch() ?>
            <?php endif ?>
          </div>
          <div class="span4">
            <label for="hajj_program">برنامج الحج</label>
            <?php if ($addon): // an addon?>
              <select name="hajj_program">
                <option value="<?php echo $hajj->hajj_program ?>"><?php echo $hajj_program ?></option>
              </select>
            <?php else: ?>
              <?php self::getHajjProgram() ?>
            <?php endif ?>
          </div>
        </div>
        <?php if ($addon): ?>
        <div class="row-fluid">
          <div class="span4"></div>
          <div class="span4"></div>
          <div class="span4">
            <label for="email">سبب الاستثناء</label>
            <?php self::getReasonException() ?>
          </div>
        </div>
        <?php endif ?>
        <input type="submit" value="حجز و تسجيل" class="btn btn-success">
      </form>
    <?php
}

/*
|------------------------------------------------------------------------------------
| Get the Form of Hajj register
|------------------------------------------------------------------------------------
*/
  public static function getEditFormHajj($data, $is_admin=false, $all_read_only=false, $is_addon=false){

    // Set Email to empty
    if (strpos($data->email, "gmail.ww")) {
      $data->email = "";
    } 

    // if addon we retrieve the branch + program
    if ($is_addon) {
      $office_branch = self::$officeBranch[$data->office_branch-1];
      $hajj_program  = self::$hajjProgram[$data->hajj_program-1];
    }

    // If read only we add alert
    if ($all_read_only): ?>
      <div class="alert fade in alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>لا يمكنك تعديل البيانات</strong> لقد تم توقيف التحويل لديك
      </div>
    <?php endif ?>

      <form action="index.php?option=com_hajj&task=hajj.setedithajj" method="post" accept-charset="utf-8" <?php echo ($all_read_only)? 'class="disabled"':''; ?>>
        <input type="hidden" name="id_user" value="<?php echo $data->id_user ?>">
        <div class="row-fluid">
          <div class="span4">
            <label for="third_name">الاسم الثالث</label>
            <input type="text" name="third_name" id="third_name" value="<?php echo $data->third_name ?>" required>
          </div>
          <div class="span4">
            <label for="second_name">الاسم الثاني</label>
            <input type="text" name="second_name" id="second_name" value="<?php echo $data->second_name ?>" required>
          </div>
          <div class="span4">
            <label for="first_name">الاسم الاول</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $data->first_name ?>" required>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="nationality">الجنسية</label>
            <?php HajjFieldHelper::getListNationnality($data->nationality) ?>
          </div>
          <div class="span4">
            <label for="sexe">الجنس</label>
            <?php HajjFieldHelper::getsexe($data->sexe) ?>
          </div>
          <div class="span4">
            <label for="familly_name">العائلة</label>
            <input type="text" name="familly_name" id="familly_name" value="<?php echo $data->familly_name ?>" required>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="id_number">رقم الهوية / الإقامة</label>
            <input type="text" name="id_number" id="id_number" value="<?php echo $data->id_number ?>" disabled pattern="[0-9]{10}" placeholder="يجب أن يكون عشرة أرقام">
          </div>
          <div class="span4">
            <label for="birthday">تاريخ الميلاد</label>
            <?php HajjFieldHelper::getBirthday($data->birthday) ?>
          </div>
          <div class="span4">
            <label for="job">الوظيفة</label>
            <input type="text" name="job" id="job" value="<?php echo $data->job ?>" required>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="rh">فصيلة الدم</label>
            <?php HajjFieldHelper::getRH($data->rh) ?>
          </div>
          <div class="span4">
            <label for="address">العنوان</label>
            <input type="text" name="address" id="address" value="<?php echo $data->address ?>" required>
          </div>
          <div class="span4">
            <label for="mobile">الجوال</label>
            <input type="text" name="mobile" id="mobile" value="<?php echo $data->mobile ?>" required placeholder="05xxxxxxxx"> <!-- pattern="05[0-9]{8}" -->
          </div>
        </div>
        <div class="row-fluid">
          <div class="span4">
            <label for="email">البريد الالكتروني</label>
            <input type="text" name="email" id="email" value="<?php echo $data->email ?>">
          </div>
          <div class="span4">
            <label for="office_branch">فرع التسجيل</label>
            <?php if ($is_addon): // an addon?>
              <select name="office_branch">
                <option value="<?php echo $data->office_branch ?>"><?php echo $office_branch ?></option>
              </select>
            <?php else: ?>
              <?php HajjFieldHelper::GetOfficeBranch($data->office_branch, true, $is_addon) ?>
            <?php endif ?>
          </div>
          <div class="span4">
            <label for="hajj_program">برنامج الحج</label>
            <?php if ($is_addon): // an addon?>
              <select name="hajj_program">
                <option value="<?php echo $data->hajj_program ?>"><?php echo $hajj_program ?></option>
              </select>
            <?php else: ?>
              <?php HajjFieldHelper::getHajjProgram($data->hajj_program, true, $is_addon) ?>
            <?php endif ?>
          </div>
        </div>
        <div class="row-fluid">
        <?php if ($is_admin): ?>
          <div class="span4">
            <label for="topay">المبلغ المطلوب</label>
            <input type="text" name="topay" id="topay" value="<?php echo $data->topay ?>" required>
          </div>
          <div class="span4">
            <label for="register_status">حالة الحجز</label>
            <?php HajjFieldHelper::getListStatusHajjs($data->register_status) ?>
          </div>
        <?php else : ?>
          <div class="span4"></div><div class="span4"></div>
        <?php endif ?>
          <div class="span4">
            <label>توقيت التسجيل</label>
            <input class="date_register" type="text" disabled value="<?php echo $data->date_register ?>" placeholder="">
          </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $data->id ?>">
        <input type="submit" value="حفظ التعديل" class="btn btn-success">
      </form>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get Hajj Program
|------------------------------------------------------------------------------------
*/
  public static function getReasonException($active = ""){
    ?>
      <select name="reason_exception" id="reason_exception" required>
        <option value="0"></option>
        <?php foreach (self::$reason_exception as $key => $value): ?>
          <option <?php echo ($active == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>"><?php echo $value ?></option>
        <?php endforeach ?>
      </select>
    <?php
  }  

/*
|------------------------------------------------------------------------------------
| Get List Status Hajjs
|------------------------------------------------------------------------------------
*/
  public static function getListStatusHajjs($active = ""){
    ?>
      <select name="register_status" id="register_status" required <?php echo ($active == 3 || $active == 5) ? "disabled":"" ?>>
        <?php foreach (self::$status_hajjs as $key => $value): ?>
            <option <?php echo ($active == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>">
              <?php echo $value ?>
            </option>
        <?php endforeach ?>
      </select>
    <?php 
  }

/*
|------------------------------------------------------------------------------------
| Get List Status 
|------------------------------------------------------------------------------------
*/
  public static function getListStatusPayment($active = ""){
    ?>
      <select name="status" id="status" required>
        <?php foreach (self::$status_payment as $key => $value): ?>
            <option <?php echo ($active == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>">
              <?php echo $value ?>
            </option>
        <?php endforeach ?>
      </select>
    <?php 
  }

/*
|------------------------------------------------------------------------------------
| Get List Status 
|------------------------------------------------------------------------------------
*/
  public static function getListAccountOwner($active = ""){
    ?>
      <select name="account" id="account" required>
        <?php foreach (self::$account_owner as $key => $value): ?>
            <option <?php echo ($active == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>">
              <?php echo $value ?>
            </option>
        <?php endforeach ?>
      </select>
    <?php 
  }

/*
|------------------------------------------------------------------------------------
| Status register
|------------------------------------------------------------------------------------
*/
  public static function status_register($id){
    return isset(self::$status_hajjs[$id-1]) ? self::$status_hajjs[$id-1] : "" ;
  }

/*
|------------------------------------------------------------------------------------
| Get the Form of Programs
|------------------------------------------------------------------------------------
*/
  public static function getFormProgram($toEdit = "", $readonly = TRUE){
    ?>
    <form action="index.php?option=com_hajj&task=admin.setProgram" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span4">
          <label for="status">حالة البرنامج</label>
          <select name="status">
            <option value="1" <?php echo ($toEdit != "" && $toEdit->status == "1") ? "selected" : "" ?>>نشط</option>
            <option value="0" <?php echo ($toEdit != "" && $toEdit->status == "0") ? "selected" : "" ?>>ايقاف</option>
          </select>
        </div>
        <div class="span4">
          <label for="price_program">سعر البرنامج</label>
          <input type="text" name="price_program" id="price_program" value="<?php echo ($toEdit != "") ? $toEdit->price_program : 0 ?>"  <?php echo ($readonly) ? "disabled" : "" ?>>
        </div>
        <div class="span4">
          <label for="name">اسم البرنامج</label>
          <input type="text" name="name" id="name" value="<?php echo ($toEdit != "") ? $toEdit->name : "" ?>" required <?php echo ($readonly) ? "disabled" : "" ?>>
        </div>
        <input type="hidden" name="id" value="<?php echo ($toEdit != "") ? $toEdit->id : "" ?>">
      </div>

      <input type="submit" name="" value="حفظ" class="btn btn-success">

    </form>

    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get the Form of Programs
|------------------------------------------------------------------------------------
*/
  public static function getFormtents($toEdit = ""){
    $hajj_program = ($toEdit) ? $toEdit->hajj_program: "";
    $status = ($toEdit) ? $toEdit->status: "";
    $sexe = ($toEdit) ? $toEdit->sexe: "";
    $name = ($toEdit) ? $toEdit->name: "";

    ?>
    <form action="index.php?option=com_hajj&task=admin.setTents" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span4">
          <label for="nb_family">عدد الأسرة</label>
          <input type="text" name="nb_family" id="nb_family" value="<?php echo ($toEdit != "") ? $toEdit->nb_family : "0" ?>">
        </div>
        <div class="span4">
          <label for="hajj_program">برنامج الحج</label>
          <?php HajjFieldHelper::getHajjProgram($hajj_program) ?>
        </div>
        <div class="span4">
          <label for="id">رقم الخيمة</label>
          <input type="text" name="id" id="id" value="<?php echo ($toEdit != "") ? $toEdit->id : "0" ?>" disabled>
        </div>
      </div>

      <div class="row-fluid">
        <div class="span4">
          <label for="status">حالة الخيمة</label>
          <?php HajjFieldHelper::GetStatusTents($status) ?>
        </div>
        <div class="span4">
          <label for="sexe">مخصص الى</label>
          <?php HajjFieldHelper::GetSexeTents($sexe) ?>
        </div>
        <div class="span4">
          <label for="name">المخيم</label>
          <?php HajjFieldHelper::GetNameTents($name) ?>
        </div>
      </div>


      <input type="hidden" name="id" value="<?php echo ($toEdit != "") ? $toEdit->id : "" ?>">

      <input type="submit" name="" value="حفظ" class="btn btn-success">

    </form>

    <?php
  }

/*
|------------------------------------------------------------------------------------
|  Get Name Tents
|------------------------------------------------------------------------------------
*/
  public static function GetNameTents($active = ""){
      $model        = JModelLegacy::getInstance('Admin', 'HajjModel');
      $Camps   = $model->getCamps();
    ?>
      <select name="name" id="name" required>
      <?php foreach ($Camps as $key => $Camp): ?>
        <option <?php echo ($active == $Camp->id) ? "selected" : "" ?> value="<?php echo $Camp->id ?>"><?php echo $Camp->id . " - الفئة : " . $Camp->group . " - المربع : " . $Camp->box ?></option>
      <?php endforeach ?>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
|  Get Status Tents
|------------------------------------------------------------------------------------
*/
  public static function GetStatusTents($active = ""){
    ?>
      <select name="status" id="status" required>
        <option <?php echo ($active == "1") ? "selected" : "" ?> value="1"><?php echo self::$status_tents[1] ?></option>
        <option <?php echo ($active == "0") ? "selected" : "" ?> value="0"><?php echo self::$status_tents[0] ?></option>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
|  Get Sexe Tents
|------------------------------------------------------------------------------------
*/
  public static function GetSexeTents($active = ""){
    ?>
      <select name="sexe" id="sexe" required>
        <option <?php echo ($active == "0") ? "selected" : "" ?> value="0"><?php echo self::$sexe[0] ?></option>
        <option <?php echo ($active == "1") ? "selected" : "" ?> value="1"><?php echo self::$sexe[1] ?></option>
      </select>
    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get the Form of Payment
|------------------------------------------------------------------------------------
*/
  public static function getFormPayment($data = "", $idHajj = 0, $idPayment = 0, $is_admin = false){
    $readonly = ($is_admin == true && $data!='') ? 'disabled' : '';
    ?>

    <form action="index.php?option=com_hajj&task=hajj.setPayment"  enctype="multipart/form-data" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span4">
          <label for="amount">مبلغ الدفعة</label>
          <input type="number" name="amount" id="amount" value="<?php echo ($data != "") ? $data->amount : "" ?>" required <?php echo $readonly ?>>
        </div>
        <div class="span4">
          <label for="account_owner">صاحب الحساب</label>
          <input type="text" name="account_owner" id="account_owner" value="<?php echo ($data != "") ? $data->account_owner : "" ?>" required>
        </div>
        <div class="span4">
          <label for="account">الحساب</label>
          <?php if ($data == ""): 
              HajjFieldHelper::getListAccountOwner();
            else: 
              HajjFieldHelper::getListAccountOwner($data->account);
            endif ?>
        </div>
      </div>
      <div class="row-fluid">
        <?php if ($is_admin): ?>
          <div class="span4">
            <label for="account">حالة الدفعة</label>
            <?php if ($data == ""): 
              HajjFieldHelper::getListStatusPayment();
            else: 
              HajjFieldHelper::getListStatusPayment($data->status);
            endif ?>
          </div>
        <?php endif ?>
        <div class="span4 <?php echo (!$is_admin) ? "offset4" : "" ?>">
          <label for="attachment">ارفاق السند</label>
          <input type="file" name="attachment" id="attachment" value="" <?php echo ($data == "") ? "required" : "" ?>>
        </div>
        <div class="span4">
          <?php require_once JPATH_COMPONENT.'/helpers/' .'components.php'; ?>
          <?php HajjComponentsHelper::loadDatePicker() ?>
          <label for="date">التاريخ</label>
          <input type="text" class="datepicker" name="date" id="date" value="<?php echo ($data != "") ? $data->date : "" ?>" required autocomplete='off'>
        </div>
      </div>
      <?php if ($is_admin): ?>
       <div class="row-fluid">
       <div class="span8">
         <img src="index.php?option=com_hajj&task=admin.getImgPayment&img=<?php echo $data->attachment ?>" alt="">
       </div>
        <div class="span4">
          <label for="id_hajj">رقم الحجز</label>
          <?php HajjFieldHelper::getListHajjId($idHajj) ?>
         </div>
       </div> 
      <?php else: ?>
          <input type="hidden" name="id_hajj" value="<?php echo $idHajj ?>">
      <?php endif ?>
      <input type="hidden" name="id" value="<?php echo $idPayment ?>">
      
      <input type="submit" name="" value="حفظ" class="btn btn-success">

    </form>

    <?php
  }



/*
|------------------------------------------------------------------------------------
| Get the Form of Camps
|------------------------------------------------------------------------------------
*/
  public static function getFormCamps($toEdit = ""){
    ?>

    <form action="index.php?option=com_hajj&task=admin.setCamps" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span6">
          <label for="site">الموقع</label>
          <input type="text" name="site" id="site" value="<?php echo ($toEdit != "") ? $toEdit->site : "" ?>">
        
          <label for="coordinates">الاحداثيات</label>
          <input type="text" name="coordinates" id="coordinates" value="<?php echo ($toEdit != "") ? $toEdit->coordinates : "" ?>">
          
          <label for="status">حالة المخيم</label>
          <select name="status">
            <option value="1" <?php echo ($toEdit != "" && $toEdit->status == "1") ? "selected" : "" ?>>نشط</option>
            <option value="0" <?php echo ($toEdit != "" && $toEdit->status == "0") ? "selected" : "" ?>>ايقاف</option>
          </select>
        </div>
        <div class="span6">
          <label for="group">الفئة</label>
          <input type="text" name="group" id="group" value="<?php echo ($toEdit != "") ? $toEdit->group : "" ?>">
        
          <label for="box">المربع</label>
          <input type="text" name="box" id="box" value="<?php echo ($toEdit != "") ? $toEdit->box : "" ?>">
        
          <label for="camp">المخيم</label>
          <input type="text" name="camp" id="camp" value="<?php echo ($toEdit != "") ? $toEdit->camp : "" ?>">
        </div>
      </div>
      <input type="hidden" name="id" value="<?php echo ($toEdit != "") ? $toEdit->id : "" ?>">

      <input type="submit" name="" value="حفظ" class="btn btn-success">

    </form>

    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get the Form of Branchs
|------------------------------------------------------------------------------------
*/
  public static function getFormBranch($toEdit = "", $readonly = TRUE){
    ?>

    <form action="index.php?option=com_hajj&task=admin.setBranch" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span4">
        </div>
        <div class="span4">
          <label for="status">حالة الفرع</label>
          <select name="status">
            <option value="1" <?php echo ($toEdit != "" && $toEdit->status == "1") ? "selected" : "" ?>>نشط</option>
            <option value="0" <?php echo ($toEdit != "" && $toEdit->status == "0") ? "selected" : "" ?>>ايقاف</option>
          </select>
        </div>
        <div class="span4">
          <label for="name">اسم الفرع</label>
          <input type="text" name="name" id="name" value="<?php echo ($toEdit != "") ? $toEdit->name : "" ?>" required <?php echo ($readonly) ? "disabled" : "" ?>>
        </div>
        <input type="hidden" name="id" value="<?php echo ($toEdit != "") ? $toEdit->id : "" ?>">
      </div>

      <input type="submit" name="" value="حفظ" class="btn btn-success">

    </form>

    <?php
  }

/*
|------------------------------------------------------------------------------------
| Get List of Hajj Id
|------------------------------------------------------------------------------------
*/
  public static function getListHajjId($active = ""){

    $data        = JModelLegacy::getInstance('Admin', 'HajjModel')->getHajjs();

    ?>
    <select name="id_hajj" id="id_hajj" required>
      <option value=""></option>
      <?php foreach ($data as $key => $hajjs): ?>
        <option <?php echo ($active == $hajjs->id)? "selected":"" ?> value="<?php echo $hajjs->id ?>"><?php echo $hajjs->id . ' - ' . $hajjs->first_name . ' ' .$hajjs->familly_name  ?></option>
      <?php endforeach ?>
    </select>

    <?php
  } 

/*
|------------------------------------------------------------------------------------
| Get Form Filter
|------------------------------------------------------------------------------------
*/
  public static function getFormFilterHajjs($register_status="", $hajj_program="", $office_branch=""){
  ?>
    <form action="index.php?option=com_hajj&task=admin.hajjs&Itemid=241" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span3">
          <input type="submit" name="submit" value="تصفية" class="btn btn-success mt25">
          <a href="index.php?option=com_hajj&task=admin.hajjs&Itemid=241" class="btn btn-default mt25">الكل</a>
        </div>

        <div class="span3">
          <label for="hajj_program">برنامج الحج</label>
          <select name="hajj_program" id="hajj_program">
            <option value=""></option>
            <?php foreach (self::getPrograms(true) as $key => $value): ?>
              <option <?php echo ($hajj_program == $value->id) ? "selected" : "" ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="span3">
          <label for="office_branch">فرع التسجيل</label>
          <select name="office_branch" id="office_branch">
            <option value=""></option>
            <?php foreach (self::getBranchs($is_admin) as $key => $value): ?>
              <option <?php echo ($office_branch == $value->id) ? "selected" : "" ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="span3">
          <label for="register_status">حالة الحجز</label>
          <select name="register_status" id="register_status">
              <option value=""></option>
            <?php foreach (self::$status_hajjs as $key => $value): ?>
                <option <?php echo ($register_status == $key+1) ? "selected" : "" ?> value="<?php echo $key+1 ?>">
                  <?php echo $value ?>
                </option>
            <?php endforeach ?>
          </select>
        </div>

      </div>

    </form>
  <?php 
  } 

/*
|------------------------------------------------------------------------------------
| Get Form Filter 
|------------------------------------------------------------------------------------
*/
  public static function getFormFilterPayments($date_filter='', $id_filter='', $id_hajj=''){
  ?>
    <form action="index.php?option=com_hajj&view=payments&Itemid=249" method="post" accept-charset="utf-8">
      <div class="row-fluid">
        <div class="span3">
          <input type="submit" name="submit" value="تصفية" class="btn btn-success mt25">
          <a href="index.php?option=com_hajj&view=payments&Itemid=249" class="btn btn-default mt25">الطلبات</a>
        </div>

        <div class="span3">
          <label for="date_filter">التاريخ</label>
          <input type="text" class="datepicker" id="date_filter" name="date_filter" value="<?php echo $date_filter ?>" placeholder="">
        </div>

        <div class="span3">
          <label for="id_filter">رقم الدفعة</label>
          <input type="text" name="id_filter" id="id_filter" value="<?php echo $id_filter ?>" placeholder="">
        </div>

        <div class="span3">
          <label for="id_hajj">رقم الحجز</label>
          <input type="text" name="id_hajj" id="id_hajj" value="<?php echo $id_hajj ?>" placeholder="">
        </div>

      </div>

    </form>
  <?php 
  }


}// End Class 