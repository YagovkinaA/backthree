<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8'); 

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
    if (!empty($_GET['save'])) {
      // Если есть параметр save, то выводим сообщение пользователю.
      print('Спасибо, результаты сохранены.');
    }
    include('form.php'); // Включаем содержимое файла form.php.
    exit(); // Завершаем работу скрипта.
}

$result;

// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
try{
    // Проверяем ошибки.
    $errors = FALSE;
    if (empty($_POST['field-name'])) {
        print('Заполните имя.<br/>');
        $errors = TRUE;
    }
    if (empty($_POST['field-email'])) {
        print('Заполните почту.<br/>');
        $errors = TRUE;
    }

    if (empty($_POST['BIO'])) {
        print('Заполните биографию.<br/>');
        $errors = TRUE;
    }
    if (empty($_POST['ch'])) {
        print('Вы должны быть согласны с условиями.<br/>');
        $errors = TRUE;
    }

    
    if ($errors) {
      // При наличии ошибок завершаем работу скрипта.
        exit();
    }
    //передаем данные в переменные
    $name = $_POST['field-name'];
    $email = $_POST['field-email'];
    $dob = $_POST['field-date'];
    $gender = $_POST['radio-gender'];
    $limbs = $_POST['radio-limb'];
    $bio = $_POST['BIO'];
    $che = $_POST['ch'];
    
    //Объединяет элементы массива в строку
    $sup= implode(",",$_POST['superpower']);

    //Представляет собой соединение между PHP и сервером базы данных.
    $conn = new PDO("mysql:host=localhost;dbname=baza", 'root', 'root', array(PDO::ATTR_PERSISTENT => true));

    //Подготавливает инструкцию к выполнению и возвращает объект инструкции
    $user = $conn->prepare("INSERT INTO form SET name = ?, email = ?, dob = ?, gender = ?, limbs = ?, bio = ?, che = ?");

    //Запускает подготовленный запрос на выполнение
    $user -> execute([$_POST['field-name'], $_POST['field-email'], date('Y-m-d', strtotime($_POST['field-date'])), $_POST['radio-gender'], $_POST['radio-limb'], $_POST['BIO'], $_POST['ch']]);
    $id_user = $conn->lastInsertId();

    $user1 = $conn->prepare("INSERT INTO super SET id = ?, super_name = ?");
    $user1 -> execute([$id_user, $sup]);
    $result = true;
    //  user и user1 - это "дескриптор состояния".
}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}


if ($result) {
  echo "Информация занесена в базу данных под ID №" . $id_user;
}
//print - выводит строку, а echo - 1 или больше строк
?>