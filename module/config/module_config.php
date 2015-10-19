<table width="100%">
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Nhân viên : ',$util->buildUserSelect (),'userDropDown'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module key : ',$util->generateHTMLField ($util->initSimpleTextField('key_module_of_user')),''); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module : ',$util->buildModuleSelect (),'menuDropDown'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub module key : ',$util->generateHTMLField ($util->initSimpleTextField('key_sub_module_of_module')),''); ?>
	</tr>
	<tr>
		<?php  echo $util->generateTdBlockLabelAndField('Module mặc định : ',$util->buildModuleSelectByUser ( $_SESSION ['session_id_of_user'] ),'userMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Module name : ',$util->generateHTMLField ($util->initSimpleTextField('name_module_of_user')),''); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub mặc định : ',$util->buildSubModuleSelectByModule ( $_SESSION ['session_active_menu'] ),'subMenuActive'); ?>
		<?php  echo $util->generateTdBlockLabelAndField('Sub module name : ',$util->generateHTMLField ($util->initSimpleTextField('name_sub_module_of_module')),''); ?>
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


