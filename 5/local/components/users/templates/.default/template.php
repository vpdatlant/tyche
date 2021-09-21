<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

?>
<form action="#" method="POST">
	<div class="hd_search_form" style="float:left;">
		<input placeholder="Поиск" type="text" name="search"/>
		<input type="submit" value=""/>
	</div>
</form>

<div style="clear: both;"></div>
<br>
<?
	//var_dump($arResult['rsUsers']);
	while($arItem= $arResult['rsUsers']->GetNext())	
	{ ?>
		<form action='<?=$arItem['LOGIN']?>' method='post'>
			<input type='hidden' name='email' value='<?=$arItem['EMAIL']?>'>
			<input type='hidden' name='date_register' value='<?=$arItem['DATE_REGISTER']?>'>
			<input type='hidden' name='last_login' value='<?=$arItem['LAST_LOGIN']?>'>
		<a href = '' onClick='this.parentNode.submit(); return false;'>[<?=$arItem['ID']?>] (<?=$arItem['LOGIN']?>) <?=$arItem['EMAIL']?> <?=$arItem['LAST_NAME']?><a><br>
		</form>
	<?}
?>

