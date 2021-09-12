<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

?>
<form action="#" method="POST">
	<div class="hd_search_form" style="float:left;">
		<input placeholder="Поиск" type="text" name="search"/>
		<input type="submit" value=""/>
	</div>
</form>
<div style="clear: both;"></div>
<?
	if (isset($_POST["search"])) {
		$filter = Array("EMAIL" => $_POST["search"]);
	}else{
		$filter =  Array("EMAIL" => "");
	}

	$rsUsers = CUser::GetList(($by = "DATE_REGISTER"), ($order = "asc"), $filter);
	while($arItem= $rsUsers->GetNext())	
	{
		echo "<a href = 'detail.php?login=".$arItem['LOGIN']."'>[". $arItem['ID']."] (".$arItem['LOGIN'].") ".$arItem['EMAIL']." ".$arItem['LAST_NAME']."<a><br>";	
	}
?>

