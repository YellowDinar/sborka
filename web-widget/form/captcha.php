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
   * Class Captcha
   *
   * @package Form
   */
  class Captcha
  {


    /**
     * Default Properties
     * @var array
     */
    public $properties = array(
      "type"   => "numbers",
      "length" => 4,
      "width"  => 100,
      "height" => 40,
      "font"   => 19
    );


    /**
     * symbols for captcha
     * @var array
     */
    protected $symbols = array(
      "numbers"           => "0123456789",
      "words"             => "ABCDEFGKIJKLMNOPQRSTUVWXYZ",
      "words_and_numbers" => "0123456789ABCDEFGKIJKLMNOPQRSTUVWXYZ"
    );


    /**
     * Image captcha
     * @var null
     */
    public $captcha = null;


    /**
     * Available types: "expression", "numbers", "words", "words_and_numbers"
     * @param string $type
     * @return $this
     */
    public function type($type)
    {
      if(is_string($type))
        $this->properties["type"] = $type;

      return $this;
    }


    /**
     * Length captcha
     * @param integer $length
     * @return $this
     */
    public function length($length)
    {
      if(is_integer($length))
        $this->properties["length"] = $length;

      return $this;
    }


    /**
     * Print the image captcha
     * @param $instance
     * @param $name
     */
    public function show($instance, $name)
    {
      if( ! session_id())
        session_start();

      $font   = dirName(__FILE__) . "/captcha.ttf";

      /**
       * Create an image
       */
      $this->captcha = imagecreatetruecolor($this->properties["width"], $this->properties["height"]);
      imagesavealpha($this->captcha, true);

      /**
       * Perform fill random color
       */
      $bg = imagecolorallocatealpha($this->captcha, rand(150, 255), rand(150, 255), rand(150, 255), 100);
      imagefill($this->captcha, 0, 0, $bg);

      /**
       * Create noise
       */
      for($n = 0; $n < $this->properties["width"] * $this->properties["height"] / 20; $n++)
        imagesetpixel($this->captcha, mt_rand(0, $this->properties["width"]), mt_rand(0, $this->properties["height"]), imagecolorallocate($this->captcha, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100)));

      /**
       * Check the path to the font file
       */
      putenv("GDFONTPATH=" . realpath("."));

      /**
       * The generated string
       */
      $result = "";
      $string = "";
      if(in_array($this->properties["type"], array_keys($this->symbols))) {
        for($n = 0; $n < $this->properties["length"]; $n++)
          $string .= $this->symbols[$this->properties["type"]][rand(0, strlen($this->symbols[$this->properties["type"]]) - 1)];
        $result = $string;
      } elseif($this->properties["type"] == "expression") {
        $n1 = rand(pow(10, $this->properties["length"]) / 10, pow(10, $this->properties["length"]) - 1);
        $n2 = rand(pow(10, $this->properties["length"]) / 10, pow(10, $this->properties["length"]) - 1);
        $this->properties["length"] = $this->properties["length"] * 2 + 3;
        $string = $n1 . " + " . $n2;
        $result = $n1 + $n2;
      }

      /**
       * The recorded response
       */
      $_SESSION["wwForm"][$instance]["captcha_" . $name] = $result;

      /**
       * Draw a line
       */
      for($n = 0; $n < $this->properties["length"]; $n++) {
        $col = ($this->properties["width"] - 20) / $this->properties["length"];
        $x   = $col * ($n + 1) - $col / 2 - $this->properties["font"] / 2.5 + 10;
        $x   = rand($x, $x + 4);
        $y   = $this->properties["height"] - (($this->properties["height"] - $this->properties["font"]) / 2);
        $color = imagecolorallocate($this->captcha, rand(0, 130), rand(0, 130), rand(0, 130));
        $angle = $string[$n] != "+" ? rand(-25, 25) : 0;
        imagettftext($this->captcha, $this->properties["font"], $angle, $x, $y, $color, $font, $string[$n]);
      }

      /**
       * The image displayed
       */
      header("Content-type: image/png");
      imagepng($this->captcha);
      imagedestroy($this->captcha);

      exit();
    }


  }