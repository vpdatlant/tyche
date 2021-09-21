<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пользователь");
?>
<p>LOGIN: <?=$_GET["login"]?></p>
<p>EMAIL: <?=$_POST["email"]?></p>
<p>ДАТА РЕГИСТРАЦИИ: <?=$_POST["date_register"]?></p>
<p>ПОСЛЕДНЯЯ АВТОРИЗАЦИЯ: <?=$_POST["last_login"]?></p>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
