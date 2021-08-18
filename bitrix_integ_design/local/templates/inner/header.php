<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<?$APPLICATION->ShowHead();?>
	<title><?$APPLICATION->ShowTitle()?></title>

	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/.default/template_style.css");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/.default/js/jquery-1.8.2.min.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/.default/js/functions.js");?>


	<link rel="shortcat icon" type="image/x-icon" href="/bitrix/templates/.default/favicon.ico"/>
	
	<!--[if gte IE 9]><style type="text/css">.gradient {filter: none;}</style><![endif]-->
</head>
<body>
	<?$APPLICATION->ShowPanel();?>
	<div class="wrap">
		<div class="hd_header_area">
			<?include_once($_SERVER['DOCUMENT_ROOT']."/bitrix/templates/.default/include/header.php");?>
		</div>
		
		<!--- // end header area --->
			<?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"nav",
				Array(
					"PATH" => "",
					"SITE_ID" => "s1",
					"START_FROM" => "0"
				)
				);?>
		<div class="main_container page">
			<div class="mn_container">
				<div class="mn_content">
					<div class="main_post">
						<div class="main_title">
						<H1 align="center"><?$APPLICATION->ShowTitle(false);?> <?$APPLICATION->ShowViewContent("ret");?></H1>
						</div>
						