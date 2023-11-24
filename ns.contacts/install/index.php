<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

class ns_contacts extends \CModule {
    public function __construct() {
        $arModuleVersion = array();

        include_once(__DIR__."/version.php");

        $this->MODULE_ID            = str_replace("_", ".", get_class($this));
        $this->MODULE_VERSION       = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE  = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME          = Loc::getMessage("MODULE_NAME");
        $this->MODULE_DESCRIPTION   = Loc::getMessage("MODULE_DESCRIPTION");
        $this->PARTNER_NAME         = Loc::getMessage("PARTNER_NAME");
        $this->PARTNER_URI          = Loc::getMessage("PARTNER_URI");
    }

    public function DoInstall() {
        global $APPLICATION;

        // Установка модуля
        RegisterModule($this->MODULE_ID);
        $this->InstallDB();
        $this->InstallEvents();

        // Вывод страницы установки модуля
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("FALBAR_TOTOP_INSTALL_TITLE")." \"".Loc::getMessage("FALBAR_TOTOP_NAME")."\"",
            __DIR__."/step.php"
        );

        return false;
    }

    public function DoUninstall() {
        global $APPLICATION;

        // Деинсталляция модуля
        $this->UnInstallDB();
        $this->UnInstallEvents();
        UnRegisterModule($this->MODULE_ID);

        // Вывод страницы деинсталляции модуля
        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("FALBAR_TOTOP_UNINSTALL_TITLE")." \"".Loc::getMessage("FALBAR_TOTOP_NAME")."\"",
            __DIR__."/unstep.php"
        );

        return false;
    }

    public function InstallDB() {
        // Логика установки базы данных модуля
        Option::set($this->MODULE_ID, "PHONE", "");
        Option::set($this->MODULE_ID, "WHATSAPP", "");
        Option::set($this->MODULE_ID, "TELEGRAM", "");
    }

    public function UnInstallDB() {
        Option::delete($this->MODULE_ID);
        return false;
    }

    public function InstallEvents() {
        // Логика регистрации событий
    }

    public function UnInstallEvents() {
        // Логика удаления событий
    }
}