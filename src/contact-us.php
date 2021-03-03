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
    class="sender__form"
    action="<?=$senderPath?>"
    method="post"
    data-sender-form="contactUs">
    <?php foreach ($contactUs as $key => $field) : ?>
      <div class="sender__form-field">
        <label for="<?=$key?>" class="sender__form-label"><?=$field['label']?></label>
        <input
          id="<?=$key?>"
          name="<?=$key?>"
          type="<?=$field['type']?>"
          placeholder="<?=$field['label']?>"
          <?=$field['required']?'required':''?>
          class="sender__form-input"
        />
        <div class="sender__error" data-sender-form-error="<?=$key?>"></div>
      </div>
    <?php endforeach; ?>
    <div class="sender__form-field">
      <button class="sender__button button button--primary" type="submit" data-sender-submit-button disabled>
        <div class="sender__button-loading-underlay loading-background"></div>
        Начать сейчас 
      </button>
    </div>
    <div class="sender__form-field">
      <div class="sender__checkbox">
        <input
          class="sender__checkbox-native"
          type="checkbox"
          value="1"
          id="privacy"
          name="privacy"
          data-sender-privacy-accept
          required />
        <span class="sender__checkbox-box">
          <span class="sender__checkbox-tick"></span>
        </span>
        <label for="privacy" class="sender__checkbox-label">Даю согласие на обработку персональных данных</label>
      </div>
      <div class="sender__error" data-sender-form-error="privacy"></div>
    </div>
  </form>
  <div class="sender__message" data-sender-message></div>
</div>
