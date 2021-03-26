<?php

include("forms.php");

$form = null;
$result = false;
$message = "";
$errors = [];
$formData = [];

if (!isset($_POST)) {
  $message = "Не получены никакие данные";
} else {
  $target = $_POST["target"];
  $isFormExist = array_key_exists($target, $forms);
  if ($isFormExist) {
    $form = $forms[$target];
    foreach ($form["fields"] as $key => $field) {
      $value = htmlspecialchars(trim(strval($_POST[$key])));
      $label = $field["label"];
      $formData[$key] = [
        "label" => $label,
        "value" => $value,
      ];
      if ($field["required"] && empty($value)) {
        $errors[$key] = "Не заполнено обязательное поле $label";
      }
    }
  } else {
    $message = "Попытка отправить несуществующую форму";
  }

  if (!isset($_POST["privacy"])) {
    $errors["privacy"] = "Согласие на обработку персональных данных обязательно";
  }

  if (count($errors) !== 0) {
    $message = "Ошибки в полях";
  } else if ($isFormExist) {
    $result = createAndSendMessage($formData, $form);
    $message = $result ? $form["success-message"] : "Не удалось отправить сообщение";
  }
}

echo json_encode([
  "success" => $result,
  "message" => $message,
  "errors" => $errors,
]);

function createAndSendMessage($formData, $form) {
  $subject = $form["email"]["subject"];
  $address = $form["email"]["to"];
  $fromAddress = "noreply@".$_SERVER["HTTP_HOST"];
  $fromName = $form["email"]["from"];

  $message = "<h1>$subject</h1>";
  foreach ($formData as $field) {
    $label = $field["label"];
    $value = $field["value"];
    $message .= "<p>$label: <strong>$value</strong></p>";
  }

  return sendEmail($address, $fromName, $fromAddress, $subject, $message);
}

function sendEmail($address, $fromName, $fromAdderss, $subject, $message) {
  $fromBase64 = "=?utf-8?B?".base64_encode($fromName)."?=";
  $subjectBase64 = "=?utf-8?B?".base64_encode($subject)."?=";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=utf-8\r\n";
  $headers .= "From: $fromBase64 <$fromAdderss>\r\n";

  return mail($address, $subjectBase64, $message, $headers, "-f $fromAdderss");
}
