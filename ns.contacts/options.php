<?php
use Bitrix\Main\Localization\Loc;
use    Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
    array(
        "DIV" => "edit",
        "TAB" => "Настройки контактов",
        "TITLE" => "Настройки контактов",
        "OPTIONS" => array(
            array(
                "PHONE",
                Loc::getMessage("OPTION_PHONE"),
                "",
                array("text", 30),
            ),
            array(
                "WHATSAPP",
                Loc::getMessage("OPTION_WHATSAPP"),
                "",
                array("text", 30),
            ),
            array(
                "TELEGRAM",
                Loc::getMessage("OPTION_TELEGRAM"),
                "",
                array("text", 30),
            ),
            array(
                "EMAIL",
                Loc::getMessage("OPTION_EMAIL"),
                "",
                array("text", 30),
            ),
        ),
        
    ),
);
$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);
  
$tabControl->Begin();
?>
<form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">

<?
 foreach($aTabs as $aTab){

     if($aTab["OPTIONS"]){

       $tabControl->BeginNextTab();

       __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
    }
 }

 $tabControl->Buttons();
?>

 <input type="submit" name="apply" value="<? echo(Loc::GetMessage("OPTION_APPLY")); ?>" class="adm-btn-save" />
  <input type="submit" name="default" value="<? echo(Loc::GetMessage("OPTION_CANSEL")); ?>" />

 <?
 echo(bitrix_sessid_post());
?>

</form>
<?php
$tabControl->End();
?>

<script>
    // Валидация телефона (принимаются только цифры)
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('input[name="PHONE"]').addEventListener('input', function () {
            this.value = this.value.replace(/[^\d]/g, '');
        });
    });
</script>

<?
if($request->isPost() && check_bitrix_sessid()){

    foreach($aTabs as $aTab){

       foreach($aTab["OPTIONS"] as $arOption){

           if(!is_array($arOption)){

               continue;
           }

           if($arOption["note"]){

                continue;
           }

           if($request["apply"]){
                $optionValue = $request->getPost($arOption[0]);

                if($optionValue == "") {
                    $optionValue = "";
                }

               Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            }elseif($request["default"]){

             Option::set($module_id, $arOption[0], $arOption[2]);
            }
       }
   }

   LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
}
