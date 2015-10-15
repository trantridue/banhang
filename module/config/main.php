<?php
echo $_SESSION ['session_selected_menu'] . " : " . $_SESSION ['session_selected_sub_menu'];
?>
<?php
$field = new Field();
$field->id='menu_id'; 
$field->type='select'; 
$field->defaultKey='a;b;c'; 
$field->defaultValue='vala;valb;valc'; 
$field->onChange='showSelected(this.id)'; 
$field->activeItem='valb';
echo $util->generateHTMLField($field, 'select_', '', '');
?>