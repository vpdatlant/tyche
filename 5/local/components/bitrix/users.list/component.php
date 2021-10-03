<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($_POST["search"])) {
	$arParams['search'] =  trim($_POST["search"]);
}
else{
	$arParams['search'] = "";
}

if ($this->startResultCache())
{
	$arResult['USERS'] = $this->GetUserList($arParams['search']);
	$this -> includeComponentTemplate();
}



?>
