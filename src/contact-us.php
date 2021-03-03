<?php

defined('_JEXEC') or die;

include('fields.php');

$senderPath = '/templates/'.$app->getTemplate().'/forms/sender.php';
//TODO вынести описание формы и текст кнопки в конфиг
//TODO имена полей клеить с именем формы


?>

<div class="sender" data-sender>
  <div class="sender__description"></div>
  <form
    class="form"
    action="<?=$senderPath?>"
    method="post"
    data-sender-form="contactUs">
    <?php foreach ($contactUs as $key => $field) : ?>
      <div class="form__field">
        <label for="<?=$key?>" class="form__label"><?=$field['label']?></label>
        <input
          id="<?=$key?>"
          name="<?=$key?>"
          type="<?=$field['type']?>"
          placeholder="<?=$field['label']?>"
          <?=$field['required']?'required':''?>
          class="form__input input"
        />
        <div class="sender__error" data-sender-form-error="<?=$key?>"></div>
      </div>
    <?php endforeach; ?>
    <div class="form__field">
      <button class="form__button button button--primary" type="submit" data-sender-submit-button disabled>
        <div class="button__loading-underlay loading-background"></div>
        Начать сейчас 
      </button>
    </div>
    <div class="form__field">
      <div class="checkbox">
        <input
          class="checkbox__native"
          type="checkbox"
          value="1"
          id="privacy"
          name="privacy"
          data-sender-privacy-accept
          required />
        <span class="checkbox__box">
          <span class="checkbox__tick"></span>
        </span>
        <label for="privacy" class="checkbox__label">Даю согласие на обработку персональных данных</label>
      </div>
      <div class="sender__error" data-sender-form-error="privacy"></div>
    </div>
  </form>
  <div class="sender__message" data-sender-message></div>
</div>
