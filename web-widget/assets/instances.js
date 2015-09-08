/**
 * Основные настройки
 */
var
  color = "#094D50",  // Код цвета для виджетов
  layout = "glass";    // Тема для виджетов ("default", "glass")



/***********************************************************
 *
 *  Экземпляры виджетов. Не зная, править не рекомендуется.
 *
 ***********************************************************/
documentOnLoad(function()
{

  if(typeof WebWidget != "function") {
    debugError("Library not found WebWidget!");
    return;
  }
  var
    _instance, selector, _selector, _form, _window, _sAll, s,
    action = "/web-widget/instances.php";


  /**
   * Static form
   */
  selector = ".ww_form_static";
  if(document.querySelector(selector)) {
    _sAll = document.querySelectorAll(selector);
    for(s = 0; s < _sAll.length; s++)
      if(_sAll[s].hasAttribute("data-form"))
        createForm(_sAll[s], _sAll[s].getAttribute("data-form"));
  }


  /**
   * create form
   *
   * @param sel
   * @param form
   */
  function createForm(sel, form)
  {
    _instance = new WebWidget();
    _form = {
      inner: sel,
      form: form,
      action: action,
      layout: layout,
      color: color
    };
    _instance.createForm(_form);
  }


  /**
   * Form window
   */
  selector = ".ww_form_window";
  if(document.querySelector(selector)) {
    var sAll = [];
    _sAll = document.querySelectorAll(selector);
    for(s = 0; s < _sAll.length; s++) {
      if(_sAll[s].hasAttribute("data-form") && _sAll[s].hasAttribute("data-type")) {
        var
          inst = _sAll[s].getAttribute("data-form"),
          type = _sAll[s].getAttribute("data-type"),
          title = _sAll[s].hasAttribute("data-title") ? _sAll[s].getAttribute("data-title") : null,
          sel = selector + "[data-form=" + inst + "][data-type=" + type + "]";
        if( ! inArray(sel, sAll))
          createWindowForm(sel, inst, type, title);
      }
    }
  }


  /**
   * Create window form
   *
   * @param sel
   * @param form
   * @param type
   * @param title
   */
  function createWindowForm(sel, form, type, title)
  {
    _instance = new WebWidget();
    _window = {
      type: type,
      trigger: sel,
      title: title,
      drag: false,
      size: (type == "popup" ? 420 : 360) + "px",
      layout: layout,
      color: color
    };
    _form = {
      action: action,
      form: form,
      color: color
    };
    _instance.createWindow(_window);
    _instance.createForm(_form);
    sAll.push(sel);
  }


  /**
   * Image increase
   */
  selector = ".ww_increase";
  if(document.querySelector(selector)) {
    _instance = new WebWidget();
    _instance.createWindow({
      type: "popup",
      trigger: selector,
      layout: layout,
      color: color
    });
    _instance.createIncrease({
      trigger: selector,
      layout: layout,
      color: color
    });
  }


});