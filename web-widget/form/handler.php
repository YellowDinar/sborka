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

  /**
   * Query captcha
   */
  if(array_key_exists("captcha", $_GET) && array_key_exists("instance", $_GET) && array_key_exists("name", $_GET)) {
    include_once(__DIR__ . "/captcha.php");

    $captcha = new Form\Captcha();
    $captcha
      ->type("numbers")
      ->length(4)
      ->show($_GET["instance"], $_GET["name"]);
  }

  /**
   * Connecting the Controller
   */
  include_once(__DIR__ . "/form.php");