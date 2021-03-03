<?php

include('fields.php');

if (isset($_POST)) {
  $target = $_POST['target'];

  $fields = $$target;

  $errors = [];
  $data = [];

  if (!isset($_POST['privacy'])) {
    $errors['privacy'] = "Согласие на обработку персональных данных обязательно";
  }

  foreach ($fields as $key => $field) {
    $value = htmlspecialchars(trim(strval($_POST[$key])));
    if ($field['required'] && empty($value)) {
      $fieldLabel = $field['label'];
      $errors[$key] = "Не заполнено обязательное поле $fieldLabel";
    } else {
      $data[$key] = [
        'label' => $field['label'],
        'value' => $value,
      ];
    }
  }

  if (count($errors) !== 0) {
    echo json_encode([
      "success" => false,
      "message" => "Сообщение не отправлено",
      "errors" => $errors,
    ]);
  } else {

    $result = createAndSendMessage($data, $target);

    $message = $result ? "Сообщение отправлено" : "Сообщение не отправлено";

    echo json_encode([
      "success" => $result,
      "message" => $message,
    ]);
  }
} else {
  echo json_encode([
    "success" => false,
    "message" => "Не получены никакие данные",
  ]);
}

function createAndSendMessage($data, $target) {
  switch ($target) {
    case 'jobs':
      $subject = "Отклик на вакансию";
    break;

    case 'order':
      $subject = "Запрос товара";
    break;

    default:
      $subject = "Заказ звонка";
    break;
  }

  $message = "<h1>$subject</h1>";

  foreach ($data as $field) {
    $label = $field['label'];
    $value = $field['value'];
    $message .= "<p>$label: <strong>$value</strong></p>";
  }

  $domain = $_SERVER['HTTP_HOST'];


    return sendEmail('dubaua@gmail.com', 'Отправщик почты', "noreply@$domain", $subject, $message);

}

function sendEmail($address, $fromName, $fromAdderss, $subject, $message) {
  $fromBase64 = "=?utf-8?B?".base64_encode($fromName)."?=";
  $subjectBase64 = "=?utf-8?B?".base64_encode($subject)."?=";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=utf-8\r\n";
  $headers .= "From: $fromBase64 <$fromAdderss>\r\n";

  return mail($address, $subjectBase64, $message, $headers, "-f $fromAdderss");
}

?>