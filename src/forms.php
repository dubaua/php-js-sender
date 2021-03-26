<?php

$forms = [
  "contacts" => [
    "description" => "<p>Заполните форму заказа обратного звонка и наши менеджеры свяжутся с вами в ближайшее время</p>",
    "button-text" => "заказать звонок",
    "success-message" => "Сообщение отправлено",
    "email" => [
      "to" => "dubaua@gmail.com",
      "from" => "Почтовый робот",
      "subject" => "Заказ звонка",
    ],
    "fields" => [
      "name" => [
        "label" => "Имя",
        "required" => true,
        "type" => "text",
      ],
      "phone" => [
        "label" => "Телефон",
        "required" => true,
        "type" => "text",
      ],
    ],
  ],
];
