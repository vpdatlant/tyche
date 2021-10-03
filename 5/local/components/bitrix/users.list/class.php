<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	
class CUserList extends CBitrixComponent
{
	public function onPrepareComponentParams($arParams)
	{
		$result = array(
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"]:36000000,
			"search" => trim($arParams["search"]),
		);
		return $result;
	}
	public function getUserList($SEARCH)
	{
		return CUser::GetList(($by = "LAST_LOGIN"),($order = "asc"), Array("EMAIL" => $SEARCH));
	}
}
?>
