<?php
  /**
   * Web-Widget
   * http://sv-dev.ru/ww
   *
   * @version
   * 1.0
   *
   * @copyright
   * Copyright (C) 2014-2015 Sinickij Vladimir.
   *
   * @license
   * MIT License
   */
  namespace Form;


  /**
   * Class Lingual
   *
   * @package Form
   */
  class Lingual
  {


    /**
     * @var array
     */
    static $patterns = array(

      "ru" => array(
        "sign"         => array("символ", "символа", "символов"),
        "action"       => "Не найден \"action\"!",
        "name"         => "Не найден \"name\"!",
        "to"           => "Не найден \"to\"!",
        "fields"        => "Отсутствуют поля для формы!",
        "required"     => "Поле \"##_ALIAS_##\" является обязательным для заполнения.",
        "min"          => "Минимальная длина значения для поля \"##_ALIAS_##\" - ##_ATTRIBUTE_##.",
        "max"          => "Максимальная длина значения для поля \"##_ALIAS_##\" - ##_ATTRIBUTE_##.",
        "email"        => "\"##_VALUE_##\" не является корректным почтовым адресом. Исправьте \"##_ALIAS_##\".",
        "phone"        => "\"##_VALUE_##\" не является корректным номером телефона. Исправьте \"##_ALIAS_##\".",
        "checkbox"     => "Флажок \"##_ALIAS_##\" должен быть установлен.",
        "custom"       => "Выберите значение из списка \"##_ALIAS_##\".",
        "fileRequired" => "Необходимо выбрать файл в поле \"##_ALIAS_##\".",
        "fileFormat"   => "В поле \"##_ALIAS_##\" был выбран файл с форматом не входящим в список разрешенных - ##_ATTRIBUTE_##.",
        "fileMin"      => "Минимальный размер файла \"##_ALIAS_##\" - ##_ATTRIBUTE_##.",
        "fileMax"      => "Размер файла \"##_ALIAS_##\" превышает ##_ATTRIBUTE_##.",
        "min_count"    => "Количество файлов выбранных в поле \"##_ALIAS_##\", должно быть не менее ##_ATTRIBUTE_##.",
        "max_count"    => "Количество файлов выбранных в поле \"##_ALIAS_##\", должно быть не более ##_ATTRIBUTE_##.",
        "captcha"      => "\"##_VALUE_##\" не является правильным ответом с картинки.",
        "captchaError" => "Произошла ошибка контрольной строки, попробуйте обновить страницу.",
        "maxSubmit"    => "Запрещено отправлять форму чаще 1 раза в ##_ATTRIBUTE_##"
      ),

      "en" => array(
        "sign"         => array("character", "characters", "characters"),
        "action"       => "Unknown \"action\"!",
        "name"         => "Unknown \"name\"!",
        "to"           => "Unknown \"to\"!",
        "fields"       => "There are no fields for the form!",
        "required"     => "Field \"##_ALIAS_##\" is a mandatory field.",
        "min"          => "The minimum length for the field \"##_ALIAS_##\" - ##_ATTRIBUTE_##.",
        "max"          => "The maximum length for the field \"##_ALIAS_##\" - ##_ATTRIBUTE_##.",
        "email"        => "\"##_VALUE_##\" is not a valid email address. Correct \"##_ALIAS_##\".",
        "phone"        => "\"##_VALUE_##\" is not a valid phone number. Correct \"##_ALIAS_##\".",
        "checkbox"     => "Checkbox \"##_ALIAS_##\" must be set.",
        "custom"       => "Specify a value from the list \"##_ALIAS_##\".",
        "fileRequired" => "You must select a file in the \"##_ALIAS_##\".",
        "fileFormat"   => "In the \"##_ALIAS_##\" was selected file format is not within the allowed list - ##_ATTRIBUTE_##.",
        "fileMin"      => "The minimum size of the file \"##_ALIAS_##\" - ##_ATTRIBUTE_##.",
        "fileMax"      => "File size \"##_ALIAS_##\" exceeds ##_ATTRIBUTE_##.",
        "min_count"    => "The number of files selected in the \"##_ALIAS_##\", must be at least ##_ATTRIBUTE_##.",
        "max_count"    => "The number of files selected in the \"##_ALIAS_##\", should be no more than ##_ATTRIBUTE_##.",
        "captcha"      => "\"##_VALUE_##\" not the right answer from the image.",
        "captchaError" => "There was an error control line, try refreshing the page.",
        "maxSubmit"    => "It is forbidden to send the form more than 1 time ##_ATTRIBUTE_##"
      )

    );


    /**
     * Get string from patterns
     *
     * @param $settings
     * @return mixed
     */
    static function getString($settings)
    {
      $language = array_key_exists("language", $settings) && array_key_exists($settings["language"], self::$patterns) ? $settings["language"] : "en";
      $alias = array_key_exists("alias", $settings) ? $settings["alias"] : "";
      $attribute = array_key_exists("attribute", $settings) ? $settings["attribute"] : "";
      $value = array_key_exists("value", $settings) ? $settings["value"] : "";
      $string = array_key_exists("name", $settings) && array_key_exists($settings["name"], self::$patterns[$language])
        ? self::$patterns[$language][$settings["name"]] : "An unknown error (" . $settings["name"] . ")";

      $string = str_replace("##_ALIAS_##", $alias, $string);
      $string = str_replace("##_ATTRIBUTE_##", $attribute, $string);
      $string = str_replace("##_VALUE_##", $value, $string);

      return $string;
    }


  }