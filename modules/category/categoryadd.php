<?php
////////////////////////////////////
// page load security
////////////////////////////////////
defined('LOAD_SAFE') or die('Server Error');

include("application/language/".$language."/category.lang.php");

if($_SESSION['userlevel'] >= 200 && !isset($_POST['Submit']) && !isset($_REQUEST['logout']))
{

	$sql_1 = "SELECT * FROM category";
	$query_1 = $DB->query($sql_1) or trigger_error($lang_error['SELECT_ERROR'], E_USER_ERROR);

	foreach($query_1 as $r)
	{
		
		$category_id 	= $r['id'];
		$category_name  = $r['name'];
		
		$category_subs .= "<input type=\"checkbox\" name=\"subcategory[]\" value=\"".$category_id."\"><label>".$category_name.":</label><br/>";

	}
	
	$count = 0;
	foreach($configuration->config_values['category'] as $type_value)
	{
		
		$count++;
		$category_types .= "<input type=\"checkbox\" name=\"categorytype[]\" value=\"".$type_value."\"><label>".$lang['categorytype'.$count].":</label><br/>";

	}

	$t_ = array(
		'CATEGORY_ADD_TITLE'        	=> "Category Add",
		'CATEGORY_ADD_SUB_TITLE'    	=> "Category Add Sub Title",
		'CATEGORY_NAME_LABEL'           => "Name",
		'CATEGORY_DESCRIPTION_LABEL'    => "Description",
		'CATEGORY_PICTURE_LABEL'    	=> "Picture",
		'CATEGORY_TYPE_LABEL'       	=> "Category Type",
		'CATEGORY_TYPES'      			=> $category_types,							
		'CATEGORY_SUB_LABEL'            => "Sub Category",
		'CATEGORY_SUB'            		=> $category_subs,
		'RESET'                     	=> $lang['reset'],
		'SUBMIT'                    	=> $lang['submit'],
	);

	$TEMPLATE->load("categoryadd.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}elseif($_SESSION['userlevel'] >= 200 && isset($_POST['Submit']) && !isset($_REQUEST['logout'])) {

    $name      	   = $_POST['name'];
    $description   = $_POST['description'];
    $picture   	   = $_POST['picture'];
    $categorytype  = $_POST['categorytype'];
    $subcategory   = $_POST['subcategory'];
    
    foreach($categorytype as $type_value)
    {
    
    	$type_value = $type_value.",";
    	$all_type_values .= $type_value;
    
    }
	
	$all_type_values = substr($all_type_values, 0, -1);
	
    foreach($subcategory as $sub_value)
    {
    
    	$sub_value = $sub_value.",";
    	$all_sub_values .= $sub_value;
    
    }
	
	$all_sub_values = substr($all_sub_values, 0, -1);
	
	$sql1 = "INSERT INTO category (name, description, picture, categorytype, subcategory)VALUES(?, ?, ?, ?, ?)";
	$query1 = $DB->prepare($sql1) or trigger_error($lang_error['INSERT_ERROR'], E_USER_ERROR);
	$query1->execute(array($name, $description, $picture, $all_type_values, $all_sub_values));

	$TEMPLATE->load("message.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();

}else{

	$t_ = array(
    	'MESSAGE'   => $lang['permissiondenied'],
	);

	$TEMPLATE->load("permission.tpl");
	$TEMPLATE->assign($t_);
	$TEMPLATE->publish();
}
?>
