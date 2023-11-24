<?php
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loader::includeModule("ns.contacts");

function getPhone() {
    $phoneNumber = preg_replace('/\D/', '', Option::get("ns.contacts", "PHONE", ""));

    return preg_replace('/^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$/', '$1($2) $3-$4-$5', $phoneNumber);
}

function getWhatsApp() {
    return Option::get("ns.contacts", "WHATSAPP", "");
}

function getTelegram() {
    return Option::get("ns.contacts", "TELEGRAM", "");
}

function getEmail() {
    return Option::get("ns.contacts", "EMAIL", "");
}