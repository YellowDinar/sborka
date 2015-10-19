<?php

  /**
   * Форма "Обратный звонок"
   */
  $callback_email = "dinar@aaccent.ru";                     // Адрес вашей почты
  $callback_success = "Спасибо! Заявка успешно отправлена.";  // Текст выводимый при успешной отправке
  $callback_style = "default";                                // Тема для формы ("default", "circle"), false - нет темы

  /**
   * Форма "Обратная связь"
   */
  $feedback_email = "dinar@aaccent.ru";                   // Адрес вашей почты
  $feedback_success = "Спасибо! Письмо успешно отправлено.";  // Текст выводимый при успешной отправке
  $feedback_style = "default";                                // Тема для формы ("default", "glass"), false - нет темы

/**
   * Форма на ГЛАВНОЙ "Обратная связь"
   */
  $feedback_full_email = "dinar@aaccent.ru";                   // Адрес вашей почты
  $feedback_full_success = "Спасибо! Письмо успешно отправлено.";  // Текст выводимый при успешной отправке
  $feedback_full_style = "default";                                // Тема для формы ("default", "glass"), false - нет темы



  /********************************************************
   *
   *  Экземпляры форм. Не зная, править не рекомендуется.
   *
   ********************************************************/
  include_once(__DIR__ . "/form/handler.php");
  use Form\Form as Form;
  $action_path = "/web-widget/instances.php";


  /**
   * Callback full form instance
   */
  $callback = new Form();
  $callback
    ->layout($callback_style)
    ->form("callback")
    ->action($action_path)
    ->subject("Заявка на обратный звонок")
    ->to($callback_email)
    ->success($callback_success)
    ->submitAttributes(array(
      "value" => "Заказать"
    ))
    ->fields(array(
      "phone" => array(
        "type" => "tel",
        "icon" => "☏",
        "alias" => "Телефон",
        "attributes" => array(
          "placeholder" => "Ваш телефон",
          "required" => "required",
          //"pattern" => "^[0-9 \-+()]{5,22}"
        ),
        "validate" => array(
          "required",
          "phone"
        )
      )
    ))
    ->show();


  /**
   * Callback full form instance
   */
  $callback_full = new Form();
  $callback_full
    ->layout($callback_style)
    ->form("callback_full")
    ->action($action_path)
    ->subject("Заявка на обратный звонок")
    ->to($callback_email)
    ->success($callback_success)
    ->submitAttributes(array(
      "value" => "Заказать"
    ))
    ->fields(array(
      "name" => array(
        "type" => "text",
        "alias" => "Имя",
        "attributes" => array(
          "placeholder" => "Ваше Имя"
        )
      ),
      "phone" => array(
        "type" => "tel",
        "icon" => "☏",
        "alias" => "Телефон",
        "attributes" => array(
          "placeholder" => "Ваш телефон",
          "required" => "required",
          //"pattern" => "^[0-9 \-+()]{5,22}"
        ),
        "validate" => array(
          "required",
          "phone"
        )
      ),
      "comment" => array(
        "type" => "textarea",
        "alias" => "Комментарий",
        "attributes" => array(
          "placeholder" => "Удобное время для звонка или комментарий"
        )
      )
    ))
    ->show();


  /**
   * Feedback form instance
   */
  $feedback = new Form();
  $feedback
    ->layout($feedback_style)
    ->form("feedback")
    ->action($action_path)
    ->subject("Обратная связь")
    ->to($feedback_email)
    ->success($feedback_success)
    ->submitAttributes(array(
      "value" => "Отправить"
    ))
    ->fields(array(
      "name" => array(
        "type" => "text",
        "alias" => "Имя",
        "attributes" => array(
          "placeholder" => "Ваше Имя"
        )
      ),
      "email" => array(
        "type" => "email",
        "icon" => "✉",
        "alias" => "E-Mail",
        "attributes" => array(
          "placeholder" => "Ваш E-Mail",
          "required" => "required"
        ),
        "validate" => array(
          "required",
          "email"
        )
      ),
      "message" => array(
        "type" => "textarea",
        "alias" => "Сообщние",
        "attributes" => array(
          "placeholder" => "Текст сообщения",
          "required" => "required"
        ),
        "validate" => array(
          "required"
        )
      )
    ))
    ->show();


  /**
   * Feedback full form instance
   */
  $feedback_full = new Form();
  $feedback_full
    ->layout($feedback_style)
    ->form("feedback_full")
    ->action($action_path)
    ->subject("Обратная связь")
    ->to($feedback_email)
    ->success($feedback_success)
    ->submitAttributes(array(
      "value" => "Отправить"
    ))
    ->fields(array(
      "name" => array(
        "type" => "text",
        "alias" => "Имя",
        "attributes" => array(
          "placeholder" => "Ваше Имя"
        )
      ),
      "phone" => array(
        "type" => "tel",
        "icon" => "☏",
        "alias" => "Телефон",
        "alternative" => "email",
        "attributes" => array(
          "placeholder" => "Ваш телефон"
          //"pattern" => "^[0-9 \-+()]{5,22}"
        ),
        "validate" => array(
          "required",
          "phone"
        )
      ),
      "email" => array(
        "type" => "email",
        "icon" => "✉",
        "alias" => "E-Mail",
        "alternative" => "phone",
        "attributes" => array(
          "placeholder" => "Ваш E-Mail"
        ),
        "validate" => array(
          "required",
          "email"
        )
      ),
      "message" => array(
        "type" => "textarea",
        "alias" => "Сообщние",
        "attributes" => array(
          "placeholder" => "Текст сообщения",
          "required" => "required"
        ),
        "validate" => array(
          "required"
        )
      )
    ))
    ->show();