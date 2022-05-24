<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
   // Массив для временного хранения сообщений пользователю.
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    setcookie('save', '', 100000); 
    $messages[] = 'Спасибо, результаты сохранены.';
  }
// Складываем признак ошибок в массив.
 $errors = array();
 $errors['name'] = !empty($_COOKIE['name_error']);
 $errors['email'] = !empty($_COOKIE['email_error']);
 $errors['date'] = !empty($_COOKIE['date_error']);
 $errors['pol'] = !empty($_COOKIE['pol_error']);
 $errors['parts'] = !empty($_COOKIE['parts_error']);
 $errors['biography']=!empty($_COOKIE['biography_error']);
// Выдаем сообщения об ошибках.
 if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error"> Неверный ввод имени.</div>';
  }
 if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Неправельный ввод email.</div>';
  }
 if ($errors['date']) {
    setcookie('date_error', '', 100000);
    $messages[] = '<div class="error">Выберите дату.</div>';
  }
 if ($errors['pol']) {
    setcookie('pol_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
 if ($errors['parts']) {
    setcookie('parts_error', '', 100000);
    $messages[] = '<div class="error">Укажите количество конечностей.</div>';
  }
  if ($errors['biography']) {
    setcookie('biography_error', '', 100000);
    $messages[] = '<div class="error">Раскажите о себе.</div>';
  }
// Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['pol'] = empty($_COOKIE['pol_value']) ? '' : $_COOKIE['pol_value'];
  $values['parts'] = empty($_COOKIE['parts_value']) ? '' : $_COOKIE['parts_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  if(empty($_COOKIE['abilities_value']))
    $values['abilities'] = array();
  else
    $values['abilities'] = json_decode($_COOKIE['abilities_value'], true);
  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
else{
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['name'])) {
 setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 12 * 31 * 24 * 60 * 60);
  }
if (empty($_POST['email'])) {
  setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 12 * 31 * 24 * 60 * 60);
  }
if (empty($_POST['date'])) {
  setcookie('date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('date_value', $_POST['date'], time() + 12 * 31 * 24 * 60 * 60);
  }
  if (empty($_POST['pol'])) {
    setcookie('pol_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('pol_value', $_POST['pol'], time() + 12 * 31 * 24 * 60 * 60);
  }
   if (empty($_POST['parts'])) {
    setcookie('parts_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('parts_value', $_POST['parts'], time() + 12 * 31 * 24 * 60 * 60);
  }
if (empty($_POST['biography'])) {
  setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('biography_value', $_POST['biography'], time() + 12 * 31 * 24 * 60 * 60);
  }
   if(!empty($_POST['abilities'])){
    $json = json_encode($_POST['abilities']);
    setcookie ('abilities_value', $json, time() + 12 * 31 * 24 * 60 * 60);
  }
if ($errors) {
  // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
  header('Location: index.php');
    exit();
}
else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('pol_error', '', 100000);
    setcookie('parts_error', '', 100000);
    setcookie('biography_error', '', 100000);
  }
  
$name=$_POST['name'];
$email=$_POST['email'];
$date=$_POST['date'];
$bio=$_POST['biography'];
$pol=$_POST['pol'];
$parts=$_POST['parts'];

  // Сохранение в базу данных.

$user = 'u47478';
$pass = '2559767';
$db = new PDO('mysql:host=localhost; dbname=u47478', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, date=?, pol= ?, parts= ?, bio= ?");
  $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['date'], $_POST['pol'], $_POST['parts'], $_POST['biography']]);
  
  $res = $db->query("SELECT max(id) FROM application");
    $row = $res->fetch();
    $count = (int) $row[0];
  $abilities = $_POST['abilities'];
  foreach($abilities as $item) {
      // Запись в таблицу abilities
      $stmt = $db->prepare("INSERT INTO superability SET id = ?, ability = ?");
      $stmt -> execute([$count, $item]);
    }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

 // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}