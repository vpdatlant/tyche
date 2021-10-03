<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

?>
<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
	<div class="hd_search_form" style="float:left;">
		<input placeholder="Поиск" type="text" name="search"/>
		<input type="submit" value=""/>
	</div>
</form>
<div style="clear: both;"></div>
<br>
<?
	while($arItem= $arResult['USERS']->GetNext())	
	{ ?>

		<a href = '<?=$arItem['LOGIN']?>' >[<?=$arItem['ID']?>] (<?=$arItem['LOGIN']?>) <?=$arItem['EMAIL']?> <?=$arItem['LAST_NAME']?><a><br>
	<?}
?>

