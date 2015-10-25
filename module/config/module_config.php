<table width="100%">
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Nhân viên : ',$util->buildUserSelect (),'userDropDown'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module Remain : ',$util->buildMenuDropDownRemainForUser ($_SESSION ['session_id_of_user'],'menu_remain_for_user'),'menuDropDownForUser'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module : ',$util->buildModuleSelect ('all_menu'),'menuDropDown'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub Module Remain : ',$util->buildSubModuleSelectRemainForModule ($_SESSION ['session_active_menu'],'sub_menu_remain'),'subMenuDropDownForModule'); ?>
	</tr>
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Module mặc định : ',$util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'],'menu_by_user' ),'userMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module name : ',$util->generateHTMLField ($util->initSimpleTextField('name_module_of_user')),''); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub mặc định : ',$util->buildSubModuleSelectByModule ( $_SESSION ['session_active_menu'],'sub_menu_select' ),'subMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub module name : ',$util->generateHTMLField ($util->initSimpleTextField('name_sub_module_of_module')),''); ?>
	</tr>
	
	<tr>
	<?php  echo $util->generateTdBlockLabelAndField('SỬA MODULE? : ',$util->generateHTMLField ($util->initSimpleCheckBoxField('is_modify_user_module')),''); ?>
	<td colspan="2">
	<?php echo $util->generateHTMLField($util->buildButton('update_user_module','updateMenuName','SỬA TÊN','param'));?>
	<?php echo $util->generateHTMLField($util->buildButton('add_module_to_user','addModuleToUser','SỬA MAPPING','menu_remain_for_user'));?>
	</td>
	<?php  echo $util->generateTdBlockLabelAndField('SỬA SUB MODULE? : ',$util->generateHTMLField ($util->initSimpleCheckBoxField('is_modify_module_sub_module')),''); ?>
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


