<?php
// Simulation
error_reporting(0);
 
$steamingData = [
    [
      'success'=>  true,
      'room'=> '109',
      'subject'=> 'Нисконапонски енергетски инсталации и осветление',
      'professor'=> 'Јовица Вулециќ',
      'currently'=> 'нема наставник',
      present=> 19
    ],
    [
      'success'=>  true,
      'room'=> '110',
      'subject'=> 'Математика 2',
      'professor'=> 'Јасмина Ангелевска',
      'currently'=> 'нема наставник',
      'present' => 23
    ],
    [
      'success'=>  false,
      'room'=> '111',
      'subject'=> 'Безбедност и заштита на компјутерски системи',
      'professor'=> 'Ана Чолаковска',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '122',
      'subject'=> 'Дискретна Математика',
      'professor'=> 'Сања Атанасовска',
      'currently'=> 'нема наставник',
      'present' => 7
    ],
    [
      'success'=>  true,
      'room'=> '211',
      'subject'=> 'Електроника',
      'professor'=> 'Томислав Карталов',
      'currently'=> 'нема наставник',
      'present' => 13
    ],
    [
      'success'=>  true,
      'room'=> '212',
      'subject'=> 'Складишта и обработка на податоци',
      'professor'=> 'Христијан Ѓорески',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. ЕМТА',
      'subject'=> 'Испитување на електрични машини',
      'professor'=> 'Влатко стоилков',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. релејна заштита',
      'subject'=> 'Компјутерско моделирање во електроенергетиката',
      'professor'=> 'Невенка Китева - Роглева',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. Телекомуникации',
      'subject'=> 'Радио и сателитски комуникации',
      'professor'=> 'Томислав Шуминоски',
      'currently'=> 'нема наставник',
      'present' => 0
    ]
    
    ,[
      'success'=>  true,
      'room'=> '109',
      'subject'=> 'Нисконапонски енергетски инсталации и осветление',
      'professor'=> 'Јовица Вулециќ',
      'currently'=> 'нема наставник',
      'present' => 19
    ],
    [
      'success'=>  true,
      'room'=> '110',
      'subject'=> 'Математика 2',
      'professor'=> 'Јасмина Ангелевска',
      'currently'=> 'нема наставник',
      'present' => 23
    ],
    [
      'success'=>  false,
      'room'=> '111',
      'subject'=> 'Безбедност и заштита на компјутерски системи',
      'professor'=> 'Ана Чолаковска',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '122',
      'subject'=> 'Дискретна Математика',
      'professor'=> 'Сања Атанасовска',
      'currently'=> 'нема наставник',
      'present' => 7
    ],
    [
      'success'=>  true,
      'room'=> '211',
      'subject'=> 'Електроника',
      'professor'=> 'Томислав Карталов',
      'currently'=> 'нема наставник',
      'present' => 13
    ],
    [
      'success'=>  true,
      'room'=> '212',
      'subject'=> 'Складишта и обработка на податоци',
      'professor'=> 'Христијан Ѓорески',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. ЕМТА',
      'subject'=> 'Испитување на електрични машини',
      'professor'=> 'Влатко стоилков',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. релејна заштита',
      'subject'=> 'Компјутерско моделирање во електроенергетиката',
      'professor'=> 'Невенка Китева - Роглева',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. Телекомуникации',
      'subject'=> 'Радио и сателитски комуникации',
      'professor'=> 'Томислав Шуминоски',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '109',
      'subject'=> 'Нисконапонски енергетски инсталации и осветление',
      'professor'=> 'Јовица Вулециќ',
      'currently'=> 'нема наставник',
      'present' => 19
    ],
    [
      'success'=>  true,
      'room'=> '110',
      'subject'=> 'Математика 2',
      'professor'=> 'Јасмина Ангелевска',
      'currently'=> 'нема наставник',
      'present' => 23
    ],
    [
      'success'=>  false,
      'room'=> '111',
      'subject'=> 'Безбедност и заштита на компјутерски системи',
      'professor'=> 'Ана Чолаковска',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '122',
      'subject'=> 'Дискретна Математика',
      'professor'=> 'Сања Атанасовска',
      'currently'=> 'нема наставник',
      'present' => 7
    ],
    [
      'success'=>  true,
      'room'=> '211',
      'subject'=> 'Електроника',
      'professor'=> 'Томислав Карталов',
      'currently'=> 'нема наставник',
      'present' => 13
    ],
    [
      'success'=>  true,
      'room'=> '212',
      'subject'=> 'Складишта и обработка на податоци',
      'professor'=> 'Христијан Ѓорески',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. ЕМТА',
      'subject'=> 'Испитување на електрични машини',
      'professor'=> 'Влатко стоилков',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. релејна заштита',
      'subject'=> 'Компјутерско моделирање во електроенергетиката',
      'professor'=> 'Невенка Китева - Роглева',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. Телекомуникации',
      'subject'=> 'Радио и сателитски комуникации',
      'professor'=> 'Томислав Шуминоски',
      'currently'=> 'нема наставник',
      'present' => 0
    ],[
      'success'=>  true,
      'room'=> '109',
      'subject'=> 'Нисконапонски енергетски инсталации и осветление',
      'professor'=> 'Јовица Вулециќ',
      'currently'=> 'нема наставник',
      'present' => 19
    ],
    [
      'success'=>  true,
      'room'=> '110',
      'subject'=> 'Математика 2',
      'professor'=> 'Јасмина Ангелевска',
      'currently'=> 'нема наставник',
      'present' => 23
    ],
    [
      'success'=>  false,
      'room'=> '111',
      'subject'=> 'Безбедност и заштита на компјутерски системи',
      'professor'=> 'Ана Чолаковска',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '122',
      'subject'=> 'Дискретна Математика',
      'professor'=> 'Сања Атанасовска',
      'currently'=> 'нема наставник',
      'present' => 7
    ],
    [
      'success'=>  true,
      'room'=> '211',
      'subject'=> 'Електроника',
      'professor'=> 'Томислав Карталов',
      'currently'=> 'нема наставник',
      'present' => 13
    ],
    [
      'success'=>  true,
      'room'=> '212',
      'subject'=> 'Складишта и обработка на податоци',
      'professor'=> 'Христијан Ѓорески',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. ЕМТА',
      'subject'=> 'Испитување на електрични машини',
      'professor'=> 'Влатко стоилков',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. релејна заштита',
      'subject'=> 'Компјутерско моделирање во електроенергетиката',
      'professor'=> 'Невенка Китева - Роглева',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. Телекомуникации',
      'subject'=> 'Радио и сателитски комуникации',
      'professor'=> 'Томислав Шуминоски',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '109',
      'subject'=> 'Нисконапонски енергетски инсталации и осветление',
      'professor'=> 'Јовица Вулециќ',
      'currently'=> 'нема наставник',
      'present' => 19
    ],
    [
      'success'=>  true,
      'room'=> '110',
      'subject'=> 'Математика 2',
      'professor'=> 'Јасмина Ангелевска',
      'currently'=> 'нема наставник',
      'present' => 23
    ],
    [
      'success'=>  false,
      'room'=> '111',
      'subject'=> 'Безбедност и заштита на компјутерски системи',
      'professor'=> 'Ана Чолаковска',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  true,
      'room'=> '122',
      'subject'=> 'Дискретна Математика',
      'professor'=> 'Сања Атанасовска',
      'currently'=> 'нема наставник',
      'present' => 7
    ],
    [
      'success'=>  true,
      'room'=> '211',
      'subject'=> 'Електроника',
      'professor'=> 'Томислав Карталов',
      'currently'=> 'нема наставник',
      'present' => 13
    ],
    [
      'success'=>  true,
      'room'=> '212',
      'subject'=> 'Складишта и обработка на податоци',
      'professor'=> 'Христијан Ѓорески',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. ЕМТА',
      'subject'=> 'Испитување на електрични машини',
      'professor'=> 'Влатко стоилков',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. релејна заштита',
      'subject'=> 'Компјутерско моделирање во електроенергетиката',
      'professor'=> 'Невенка Китева - Роглева',
      'currently'=> 'нема наставник',
      'present' => 0
    ],
    [
      'success'=>  false,
      'room'=> 'Лаб. Телекомуникации',
      'subject'=> 'Радио и сателитски комуникации',
      'professor'=> 'Томислав Шуминоски',
      'currently'=> 'нема наставник',
      'present' => 0
    ]
    ];

    echo json_encode($steamingData);

?>