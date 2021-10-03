<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пользователь");
?>
<p>LOGIN: <?=$_GET["login"]?></p>
<?
	$arUserDetail = CUser::GetList(($by = "LAST_LOGIN"),($order = "asc"), Array("LOGIN" => $_GET["login"]));
	$arUser=$arUserDetail->GetNext();
	
?>
<p>EMAIL: <?=$arUser["EMAIL"]?></p>
<p>ДАТА РЕГИСТРАЦИИ: <?=$arUser["DATE_REGISTER"]?></p>
<p>ПОСЛЕДНЯЯ АВТОРИЗАЦИЯ: <?=$arUser["LAST_LOGIN"]?></p>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
