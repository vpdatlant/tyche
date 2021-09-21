<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($_POST["search"])) {
	$filter = Array("EMAIL" => $_POST["search"]);
}
else{
	$filter =  Array("EMAIL" => "");
}

$arResult['rsUsers'] = CUser::GetList(($by = "LAST_LOGIN"),($order = "asc"), $filter);


$this -> includeComponentTemplate();
