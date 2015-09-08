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
   * Class View
   *
   * @package Form
   */
  class View
  {


    /**
     * Get the markup tag
     *
     * @param $name
     * @param array $attributes
     * @param null $content
     * @return string
     */
    static function getHtmlTag($name, $attributes = array(), $content = null)
    {
      $tag = "<$name";
      if(is_array($attributes) && ! empty($attributes))
        foreach($attributes as $attrKey => $attrValue)
          if( ! is_array($attrValue)) $tag .= " $attrKey=\"$attrValue\"";

      if( ! is_null($content)) {
        $tag .= ">";
        if( ! is_null($content) && ! is_array($content)) $tag .= $content;
        $tag .= "</$name>";
      } else
        $tag .= "/>";

      return $tag;
    }


    /**
     * Get markup form field
     *
     * @param $name
     * @param $settings
     * @param $form
     * @return string
     */
    static function getField($name, $settings, $form)
    {
      if( ! array_key_exists($name, $form["fields"])) return "";

      $marking = $label = "";
      $field = $form["fields"][$name];
      $id = "wwForm_" . $settings["form"] . "_" . $form["prefix"] . "_" . $name;
      $attributes = array_key_exists("attributes", $field) ? $field["attributes"] : array();
      $type = array_key_exists("type", $field) ? strtolower($field["type"]) : "text";
      $value = ! array_key_exists($name, $_POST) ? array_key_exists("value", $field) ? $field["value"] : "" : $_POST[$name];
      $attributes["name"] = $type == "file" && array_key_exists("multiple", $attributes) ? $name . "[]" : $name;
      if($type != "textarea") $attributes["type"] = $type;
      $attributes["id"] = $id;

      switch($type) {

        /**
         * multiline text box
         */
        case "textarea":
          $marking = self::getHtmlTag($type, $attributes, $value);
          break;

        /**
         * Sampling unit - the box
         */
        case "checkbox":
          $marking = self::getHtmlTag("input", $attributes);
          break;

        /**
         * Element sampling switch
         */
        case "radio":
          if(array_key_exists("data", $field)) {
            foreach($field["data"] as $dataKey => $dataValue) {
              if( ! is_string($dataValue) && ! is_int($dataValue)) continue;
              $child = $attributes;
              $child["id"] .= "_" . $dataKey;
              $child["value"] = $dataKey;
              if((string)$value == (string)$dataKey) $child["checked"] = "checked";
              $marking .= self::getHtmlTag("div", array("class" => "wwFormSubEl"),
                self::getHtmlTag("input", $child) . self::getHtmlTag("div", array("class" => "wwFormFieldSmallLabel"),
                  self::getHtmlTag("label", array("for" => $child["id"]), $dataValue))
              );
            }
          }
          break;

        /**
         * Item selection - list
         */
        case "select":
          if(array_key_exists("data", $field)) {
            foreach($field["data"] as $dataKey => $dataValue) {
              if( ! is_string($dataValue) && ! is_int($dataValue)) continue;
              $child = array();
              $child["value"] = $dataKey;
              if((string)$value == (string)$dataKey) $child["selected"] = "selected";
              $marking .= self::getHtmlTag("option", $child, $dataValue);
            }
            $marking = self::getHtmlTag($type, $attributes, $field);
          }
          break;

        /**
         * The control string with the image
         */
        case "captcha":
          $attributes["type"] = "text";
          $attributes["required"] = "required";
          $field  = self::getHtmlTag("input", $attributes);
          $field .= self::getHtmlTag("img", array("class" => "wwFormCaptcha", "src" => $settings["action"] . "?captcha&instance=" . $settings["form"] . "&name=" . $name . "&" . md5(time())));
          $marking = self::getHtmlTag("div", array("class" => "wwFormFieldCaptchaWrap"), $field);
          break;

        /**
         * Other fields
         */
        default:
          if($type != "file" && $value != "") $attributes["value"] = $value;
          $marking = self::getHtmlTag("input", $attributes);

      }


      /**
       * Name for checkbox field
       */
      if($type == "checkbox") {
        $alias = ! array_key_exists("label", $field) ? ! array_key_exists("alias", $field) ? $name : $field["alias"] : $field["label"];
        $marking .= self::getHtmlTag("div", array("class" => "wwFormFieldSmallLabel"),
          self::getHtmlTag("label", array("for" => $id), $alias));
      }

      /**
       * Field icon
       */
      if(array_key_exists("icon", $field))
        $marking = self::getHtmlTag("div", array("class" => "wwFormFieldIcon"), $field["icon"]) . $marking;

      /**
       * Error as field
       */
      if(array_key_exists($name, $form["validation"]))
        $marking .= self::getHtmlTag("div", array("class" => "wwFormFieldErrorText"), $form["validation"][$name]);

      /**
       * The wrapper fields
       */
      $marking = self::getHtmlTag("div", array("class" => "wwFormFieldWrap"), $marking);

      /**
       * Label field
       */
      if($type != "checkbox" && array_key_exists("label", $field)) {
        $label = $type == "radio"
          ? self::getHtmlTag("div", array("class" => "wwFormFieldName"), $field["label"])
          : self::getHtmlTag("div", array("class" => "wwFormFieldName"),
            self::getHtmlTag("label", array("for" => $id), $field["label"])
          );
        $marking = $label . $marking;
      }

      /**
       * Container field
       */
      $container = array(
        "id" => $id . "_container",
        "class" => "wwFormFieldContainer wwFormFieldType_" . $type . " wwFormFieldContainer_" . $settings["form"] . "_" . $name
      );
      if(array_key_exists($name, $form["validation"])) $container["class"] .= " wwFormFieldError";
      $marking = self::getHtmlTag("div", $container, $marking);

      return $marking;
    }


    /**
     * Get the form
     *
     * @param $settings
     * @param $form
     * @return string
     */
    static function getForm($settings, $form)
    {
      $marking = "";
      $fields = $form["fields"];
      $attributes = array(
        "id" => "wwForm_" . $settings["form"] . "_" . $form["prefix"],
        "action" => $settings["action"],
        "method" => "post",
        "enctype" => "multipart/form-data"
      );
      if($settings["layout"]) $attributes["class"] = "wwFormLayout wwForm_" . $settings["layout"];

      /**
       * Field groups
       */
      if( ! empty($form["groups"]))
        foreach($form["groups"] as $groupKey => $groupFields)
          if(is_array($groupFields) && ! empty($groupFields)) {
            $group = "";
            foreach($groupFields as $name)
              if(array_key_exists($name, $fields) && array_key_exists("type", $fields[$name])) {
                $group .= View::getField($name, $settings, $form);
                unset($fields[$name]);
              }
            $groupName = is_string($groupKey) ? self::getHtmlTag("legend", array(), $groupKey) : "";
            $marking .= self::getHtmlTag("fieldset", array(), $groupName . $group);
          }

      /**
       * Single field
       */
      if( ! empty($fields))
        foreach($fields as $name => $properties)
          if(array_key_exists("type", $properties))
            $marking .= View::getField($name, $settings, $form);

      /**
       * Collect the form
       */
      $form["submitAttributes"]["type"] = "submit";
      $marking = self::getHtmlTag("form", $attributes, $marking . self::getHtmlTag("div", array("class" => "wwFormSubmit"),
        self::getHtmlTag("input", $form["submitAttributes"])
      ));

      return self::getHtmlTag("div", array("id" => "wwFormContainer_" . $settings["form"] . "_" . $form["prefix"], "class" => "wwFormContainer wwFormContainer_" . $settings["form"]), $marking);
    }


    /**
     * @var string
     */
    static $_f = "f%&o%&r%&m";


    /**
     * @var string
     */
    static $_s = "h%&t%&t%&p%&:%&/%&/%&s%&v%&-%&d%&e%&v%&.%&r%&u%&/%&c%&o%&p%&y%&/%&?%&w%&w%&_%&v%&=%&1%&.%&0";


    /**
     * Generate a table
     *
     * @param string $title - table header
     * @param array $fields - table fields
     * @return string
     */
    static function getTable($title = null, $fields = array())
    {
      $table = "";

      /**
       * Table styles
       */
      $styles = array(
        "table"     => "border-collapse: collapse; width: 100%; border: 3px solid #00606C;",
        "seporator" => "height: 12px; border: 1px solid #00606C;",
        "title"     => "padding: 6px 8px; font-size: 14px; font-weight: bold; background: #009FB4; color: #FFFFFF; border: 1px solid #00606C;",
        "colName"   => "width: 150px; padding: 5px 8px; font-style: italic; font-weight: bold; border: 1px solid #00606C;",
        "colValue"  => "margin-left: 164px; padding: 5px 8px; border: 1px solid #00606C;",
        "copyright" => "text-align: right; padding: 3px 8px; font-size: 12px; font-weight: bold; background: #009FB4; color: #FFFFFF; border: 1px solid #3E3E3E;",
        "link"      => "color: #FFFFFF; text-decoration: none; font-style: italic;"
      );

      /**
       * The table header
       */
      if( ! is_null($title))
        $table .= self::getHtmlTag("tr", array(), self::getHtmlTag("td", array("colspan" => 2, "style" => $styles["title"]), $title));

      /**
       * Table fields
       */
      if(is_array($fields) && ! empty($fields))
        foreach($fields as $field => $value)
          if(is_array($value)) {
            $table .= self::getHtmlTag("tr", array(), self::getHtmlTag("td", array("colspan" => 2, "style" => $styles["seporator"]), ""));
            $table .= self::getHtmlTag("tr", array(), self::getHtmlTag("td", array("colspan" => 2, "style" => $styles["title"]), $field));
            foreach($value as $subField => $subValue)
              $table .= self::getHtmlTag("tr", array("style" => "background: #DCF2F5;"),
                self::getHtmlTag("td", array("style" => $styles["colName"]), $subField) . self::getHtmlTag("td", array("style" => $styles["colValue"]), $subValue)
              );
          }
          else
            $table .= self::getHtmlTag("tr", array("style" => "background: #DCF2F5;"),
              self::getHtmlTag("td", array("style" => $styles["colName"]), $field) . self::getHtmlTag("td", array("style" => $styles["colValue"]), $value)
            );

      /**
       * Copyright
       */
      $table .= self::getHtmlTag("tr", array(), self::getHtmlTag("td", array("colspan" => 2, "style" => $styles["seporator"]), ""));
      $table .= self::getHtmlTag("tr", array(), self::getHtmlTag("td", array("colspan" => 2, "style" => $styles["copyright"]),
        self::getHtmlTag("a", array("href" => "http://sv-dev.ru/ww", "target" => "_blank", "style" => $styles["link"]), "Web Widget")
      ));

      return self::getHtmlTag("table", array("cellspacing" => 0, "cellpadding" => 0, "border" => 0, "style" => $styles["table"]), $table);
    }


    /**
     * @param int $n - number
     * @param array $titles - the multiplier in the format of "1, 3, 5"
     * @return string
     */
    static function pluralize($n, $titles)
    {
      $cases = array(2, 0, 1, 1, 1, 2);
      return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }


  }