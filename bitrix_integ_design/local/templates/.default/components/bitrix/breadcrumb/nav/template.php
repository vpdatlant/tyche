<<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult))
	return "";

$strReturn = '<div class="bc_breadcrumbs"><ul>';
//dump($arResult);
$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	//&& $index<(count($arResult)-1)
	if($arResult[$index]["LINK"] <> "" )
	{
		$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	}
	else
	{
		$strReturn .= '<li>'.$title.'</li>';
	}
}

$strReturn .= '</ul><div class="clearboth"></div></div>';

return $strReturn;

?> 