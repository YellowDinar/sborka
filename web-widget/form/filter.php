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
   * Class Filter
   *
   * @package Form
   */
  class Filter
  {


    /**
     * Filters validation of form fields
     *
     * @var array
     */
    static $filters = array(
      "email"    => "FILTER_VALIDATE_EMAIL",
      "ip"       => "FILTER_VALIDATE_IP",
      "url"      => "FILTER_VALIDATE_URL",
      "phone"    => "/^([0-9 \-+()]{5,22})$/",
      "login"    => "/^([a-z0-9\-_@.]{6,20})$/i",
      "password" => "/^([a-z0-9\-_@.]{6,20})$/i"
    );


  }