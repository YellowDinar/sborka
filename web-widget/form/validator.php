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

  include_once(__DIR__ . "/filter.php");
  include_once(__DIR__ . "/lingual.php");


  /**
   * Class Validator
   *
   * @package Form
   */
  class Validator
  {


    /**
     * Check field instance
     *
     * @var null|object
     */
    static $instance = null;


    /**
     * Field name
     *
     * @var null
     */
    public $name = null;


    /**
     * Field value
     *
     * @var null
     */
    public $value = null;


    /**
     * Field error
     *
     * @var bool
     */
    public $error = false;


    /**
     * Check field
     *
     * @param $name
     * @param $rules
     * @param null $value
     * @return Validator
     */
    static function check($name, $rules, $value = null)
    {
      $_inst = self::$instance = new self();
      if( ! is_string($name) || ! is_array($rules)) {
        $_inst->error = "In the method were obtained incorrect data!";
        return $_inst;
      }

      /**
       * Required field
       */
      if( ! empty($rules) && in_array("required", $rules) && ! array_key_exists($name, $_POST) && ! array_key_exists($name, $_FILES))
        $_inst->error = "required";

      return array_key_exists($name, $_FILES)
        ? self::fileField($name, $rules) : self::inputField($name, $rules, $value);
    }


    /**
     * Input field
     *
     * @param $name
     * @param $rules
     * @param null $value
     * @return object
     */
    protected static function inputField($name, $rules, $value = null)
    {
      $_inst = self::$instance;
      $_inst->name = $name;
      $_val = $_inst->value = is_null($value)
        ? array_key_exists($name, $_POST) && ! is_array($_POST[$name]) ? htmlspecialchars($_POST[$name]) : "" : $value;

      if( ! empty($rules))
        foreach($rules as $ruleKey => $rule) {

          /**
           * Required field
           */
          if($rule == "required" && $_val == "") {
            $_inst->error = $rule;
            break;
          }

          /**
           * The minimum length of the field
           */
          if($ruleKey == "min" && is_int($rule) && mb_strlen($_val, "utf-8") < $rule) {
            $_inst->error = $ruleKey;
            break;
          }

          /**
           * The maximum length of the field
           */
          if($ruleKey == "max" && is_int($rule) && strlen($_val) > $rule) {
            $_inst->error = $ruleKey;
            break;
          }

          /**
           * Filters validation fields
           */
          if( ! empty(Filter::$filters)) {
            if(is_string($rule) && array_key_exists($rule, Filter::$filters)) {
              if($_val != "" && defined(Filter::$filters[$rule])){
                $const = Filter::$filters[$rule];
                $constVal = eval("return $const;");
                if( ! filter_var($_val, $constVal)) {
                  $_inst->error = $rule;
                  break;
                }
              } elseif($_val != "" && ! preg_match(Filter::$filters[$rule], $_val)) {
                $_inst->error = $rule;
                break;
              }
            }
          }

        }

      return $_inst;
    }


    /**
     * File field
     *
     * @param $name
     * @param $rules
     * @return object
     */
    protected static function fileField($name, $rules)
    {
      $_inst = self::$instance;
      $_inst->name = $name;

      if( ! empty($rules)) {

        /**
         * Multiple file field
         */
        if(is_array($_FILES[$name]["name"])) {
          $fCount = count($_FILES[$name]["name"]);
          for($i = 0; $i < $fCount; $i++) {
            $check = self::checkFile($rules, $_FILES[$name]["name"][$i], $_FILES[$name]["size"][$i], $_FILES[$name]["tmp_name"][$i]);
            if($check !== false) {
              $_inst->value = $_FILES[$name]["name"][$i];
              $_inst->error = $check;
              break;
            }
            else
              is_null($_inst->value) ? $_inst->value = $_FILES[$name]["name"][$i] : $_inst->value .= ", " . $_FILES[$name]["name"][$i];
          }

          /**
           * The minimum number of files
           */
          if($_inst->error === false && array_key_exists("min_count", $rules) && is_int($rules["min_count"]) && $fCount < $rules["min_count"])
            $_inst->error = "min_count";

          /**
           * The maximum number of files
           */
          if($_inst->error === false && array_key_exists("max_count", $rules) && is_int($rules["max_count"]) && $fCount > $rules["max_count"])
            $_inst->error = "max_count";

        /**
         * Single file field
         */
        } else {
          $check = self::checkFile($rules, $_FILES[$name]["name"], $_FILES[$name]["size"], $_FILES[$name]["tmp_name"]);
          $_inst->value = $_FILES[$name]["name"];
          if($check !== false)
            $_inst->error = $check;
        }

      }

      return $_inst;
    }


    /**
     * Check the validity of the file
     *
     * @param $rules
     * @param $fName
     * @param $fSize
     * @param $fPath
     * @return bool|string
     */
    protected static function checkFile($rules, $fName, $fSize, $fPath)
    {
      foreach($rules as $ruleKey => $rule) {
        preg_match("/([^.]+)$/", $fName, $fFormat);

        /**
         * Required file
         */
        if($rule == "required" && ! file_exists($fPath))
          return $rule;

        /**
         * Acceptable file formats
         */
        if($ruleKey == "formats" && file_exists($fPath) && is_array($rule) && ! empty($fFormat) && ! empty($rule) && ! in_array($fFormat[0], $rule))
          return $ruleKey;

        /**
         * Minimum file size
         */
        if($ruleKey == "min" && file_exists($fPath) && is_int($rule) && $fSize < $rule * 1024)
          return $ruleKey;

        /**
         * Maximum file size
         */
        if($ruleKey == "max" && file_exists($fPath) && is_int($rule) && $fSize > $rule * 1024)
          return $ruleKey;

      }

      return false;
    }


  }