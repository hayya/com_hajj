<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Call list fields
require_once JPATH_COMPONENT.'/helpers/' .'fields.php';
$data = $this->data;
$toEdit = $this->toEdit;

//var_dump($data);

?>

  <?php if ($toEdit == ""): ?>
    <?php if (!$this->readonly): ?>
      <div class="accordion" id="accordion2">
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
              <span class="btn">اضافة</span>
            </a>
          </div>
          <div id="collapseOne" class="accordion-body collapse">
            <div class="accordion-inner">
            
              <?php
                require_once JPATH_COMPONENT.'/helpers/' .'fields.php';
                HajjFieldHelper::getFormBranch($toEdit, $this->readonly);
              ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif ?>
  <?php 
    else: 
      require_once JPATH_COMPONENT.'/helpers/' .'fields.php';
      HajjFieldHelper::getFormBranch($toEdit, $this->readonly);
    endif 
  ?>



<h1>فروع الشركة</h1>
<table class="allhajjs table table-condensed table-bordered">
  <thead>
    <tr>
      <th>رقم الفرع</th>
      <th>اسم الفرع</th>
      <th>رقم المدينة في جاما</th>
      <th>حالة الفرع</th>
    </tr>
  </thead>
  <?php foreach ($data as $key => $value): ?>
    <tr>
      <td><a href="index.php?option=com_hajj&view=adminbranchs&Itemid=<?php echo $this->Itemid ?>&id=<?php echo $value->id ?>"><?php echo $value->id ?></a></td>
      <td><?php echo $value->name ?></td>
      <td><?php echo $value->gama_city_id ?></td>
      <td><?php echo ($value->status == 0) ? "ايقاف" : "نشط" ?></td>
    </tr>
  <?php endforeach ?>
</table>
