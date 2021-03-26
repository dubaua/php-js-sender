<?php
include('./forms.php');

$senderPath = '/sender.php';
$formName = 'contacts';
$form = $forms[$formName];
$privacyForId = "$formName-privacy";
?>

<div class="sender" data-sender>
  <div class="sender__description"><?=$form['description']?></div>
  <form
    class="sender__form"
    action="<?=$senderPath?>"
    method="post"
    data-sender-form>
    <?php foreach ($form['fields'] as $key => $field) :
      $forId = "{$formName}-{$key}";
      $label = $field['label'];
      ?>
      <div class="sender__form-field">
        <label for="<?=$forId?>" class="sender__form-label"><?=$label?></label>
        <input
          id="<?=$forId?>"
          name="<?=$key?>"
          type="<?=$field['type']?>"
          placeholder="<?=$label?>"
          <?=$field['required']?'required':''?>
          <?=$field['attributes']?$field['attributes']:''?>
          class="sender__form-input"
        />
        <div class="sender__error" data-sender-form-error="<?=$key?>"></div>
      </div>
    <?php endforeach; ?>
    <div class="sender__form-field">
      <button class="sender__button" type="submit" data-sender-submit-button disabled>
        <div class="sender__button-loading-underlay"></div>
        <?=$form['button-text']?>
      </button>
    </div>
    <div class="sender__form-field">
      <div class="sender__checkbox">
        <input
          class="sender__checkbox-native"
          type="checkbox"
          value="1"
          id="<?=$privacyForId?>"
          name="privacy"
          data-sender-privacy-accept
          required />
        <span class="sender__checkbox-box">
          <span class="sender__checkbox-tick"></span>
        </span>
        <label for="<?=$privacyForId?>" class="sender__checkbox-label">Даю согласие на обработку персональных данных</label>
      </div>
      <div class="sender__error" data-sender-form-error="privacy"></div>
    </div>
    <input type="hidden" name="target" value="<?=$formName?>">
  </form>
  <div class="sender__message" data-sender-message></div>
</div>
