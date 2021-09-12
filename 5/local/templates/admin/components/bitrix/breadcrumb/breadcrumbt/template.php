<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(empty($arResult))
	return "";

$strReturn = '<div class="bc_breadcrumbs"><ul>';

for($index = 0; $index < count($arResult); $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> "")
	{
		$strReturn .= '<li><a href="' . $arResult[$index]['LINK'] . '" title="' . $title .'">' . $title . '</a></li>';
	}
	else
	{
		$strReturn .= '<li>' . $title . '</li>';
	}
}

$strReturn .= '</ul><div class="clearboth"></div></div>';

return $strReturn;
