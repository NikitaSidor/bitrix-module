# Модуль ns.contacts

## Установка

1. Скопируйте папку модуля в `local/modules/`.
2. Включите модуль в административной части Битрикса.

## Зависимости

- Модуль `main`

## Настройка

1. Перейдите в раздел "Marketplace" в административной части Битрикса
2. Откройте настройки модуля `ns.contacts`.
3. Укажите необходимые контактные данные.

## Использование

```php
<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/ns.contacts/include.php");

echo getPhone();
echo getWhatsApp();
echo getTelegram();
echo getEmail();
?>
