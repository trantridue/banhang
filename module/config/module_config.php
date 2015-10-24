<table width="100%">
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Nhân viên : ',$util->buildUserSelect (),'userDropDown'); ?>
		<?php  echo $util->generateHiddenField('selected_user_id',$_SESSION ['session_id_of_user']); ?>
		<?php  echo $util->generateHiddenField('default_menu_key',$_SESSION ['session_active_menu']); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module key : ',$util->generateHTMLField ($util->initSimpleTextField('key_module_of_user')),''); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module : ',$util->buildModuleSelect ('all_menu'),'menuDropDown'); ?>
		<?php  echo $util->generateHiddenField('selected_menu_key',$_SESSION ['session_active_menu']); ?>
		<?php  echo $util->generateHiddenField('default_sub_menu_key',$_SESSION ['session_active_sub_menu']); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub module key : ',$util->generateHTMLField ($util->initSimpleTextField('key_sub_module_of_module')),''); ?>
	</tr>
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Module mặc định : ',$util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'],'menu_by_user' ),'userMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module name : ',$util->generateHTMLField ($util->initSimpleTextField('name_module_of_user')),''); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub mặc định : ',$util->buildSubModuleSelectByModule ( $_SESSION ['session_active_menu'] ),'subMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub module name : ',$util->generateHTMLField ($util->initSimpleTextField('name_sub_module_of_module')),''); ?>
	</tr>
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Module Remain User : ',$util->buildMenuDropDownRemainForUser ($_SESSION ['session_id_of_user'],'menu_remain_for_user'),'menuDropDownForUser'); ?>
		<td colspan="2">
		<?php  echo $util->generateTdBlockLabelAndField('Sub module for Module : ',$util->buildSubModuleSelect ('sub_menu_remain_for_menu'),'subMenuDropDownForModule'); ?>
	</tr>
	<tr>
	<td colspan="4">
	<?php //echo $util->generateHTMLField($util->buildButton('add_module','addNewModule','THÊM MỚI MODULE','param'));
	?>
	<?php echo $util->generateHTMLField($util->buildButton('add_module_to_user','addModuleToUser','UPDATE USER MODULE','param'));?>
	<?php echo $util->generateHTMLField($util->buildButton('update_user_module','updateModuleUser','SỬA MODULE','param'));?>
	</td>
	</tr>
	<tr>
		<td colspan="4" width="50%">
		<div id="userMenuTable">
			<?php
			echo $util->buildModuleTableByUser ( $_SESSION ['session_id_of_user'] );
			?>
		</div>
		</td>
		<td colspan="4">
		<div id="menuSubMenuTable">
			<?php
			echo $util->buildSubModuleTableByModule ( $_SESSION ['session_active_menu'] );
			?>
		</div>
		</td>
	</tr>
</table>


