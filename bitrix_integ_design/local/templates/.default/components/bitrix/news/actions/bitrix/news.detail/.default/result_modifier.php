<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// сохраняем PREVIEW_TEXT в кеше
$cp = $this->__component;
if (is_object($cp))
   $cp->SetResultCacheKeys(array('PREVIEW_TEXT'));
?>