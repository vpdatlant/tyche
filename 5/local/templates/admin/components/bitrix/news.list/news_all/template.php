<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<div class="ps_head"><a class="ps_head_link" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><h2 class="ps_head_h"><?=$arItem["NAME"]?></h2></a><span class="ps_date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span></div>
	<div class="ps_content">
		<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" align="left" alt="<?=$arItem["NAME"]?>"/> 
		<?
		$array = [];
		$newAr = [];
		$array = explode (' ', $arItem["DETAIL_TEXT"]);
		for ($i=0; $i < 10; $i++) { 
			$newAr[] = $array[$i];
		}
		?>
		<div class="main_forma">
			<div class="mina" style="display: block;">
				<?echo (implode(" " , $newAr)) . " ...";?>
				<br>
				<p class="button_all" style="color: #43b;cursor: pointer;">Показать все</p>
			</div>
			<div class="mina1"  style="display: none"><?echo $arItem["DETAIL_TEXT"];?>
				<p class="button_hide" style="color: #43b;cursor: pointer;">Скрыть все</p>
			</div>
		</div>
		
		<div style="clear:both"></div>
	</div>
<?endforeach;?>
<script>
    $(document).ready(function(){

$('.button_all').click(function(){
	$(this).closest(".mina").css("display", "none"); 
	$(this).closest(".main_forma").find(".mina1").css("display", "block"); 
});

$('.button_hide').click(function(){
	$(this).closest(".mina1").css("display", "none"); 
	$(this).closest(".main_forma").find(".mina").css("display", "block"); 
});

});
</script>
