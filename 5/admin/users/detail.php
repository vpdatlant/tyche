<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пользователь");
$rsUsers = CUser::GetList();
$rsUsers->NavStart(); 
foreach ($rsUsers->arResult as $key => $value) {
	if ($value["LOGIN"] == $_GET['login']) {
		$keyNew = $key;
	}
}
$user = $rsUsers->arResult[$keyNew];
?>
<p>LOGIN: <?=$user["LOGIN"]?></p>
<p>EMAIL: <?=$user["EMAIL"]?></p>
<p>ДАТА РЕГИСТРАЦИИ: <?=$user["DATE_REGISTER"]?></p>
<p>ПОСЛЕДНЯЯ АВТОРИЗАЦИЯ: <?=$user["LAST_LOGIN"]?></p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
