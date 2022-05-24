<html lang="ru">
  <head>
    <meta charset="utf-8">
<style>body { margin:0;
	display:flex;
	flex-direction:column;
text-align:center;
background-color:#ff9911;}
header {display:flex;
flex-direction: column;
text-align: center;
background-color:#dc3545}
	  /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
	border: 2px solid red;
	}
	  </style>
    <title> 4</title>
  </head>
  <body>
<header>
<p>Пишите правильную информацию.</p>
</header>
	  <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
	  // Класс еррор отмечает ошибки заполнения формы
// и задавая начальные значения элементов ранее сохраненными.
?>
	<form action="" method="POST">
		Имя:
	<br>
      <input type="text" name="name" 
	     <?php if ($errors['name']) {print 'class="error"';} ?>
	     value="<?php print $values['name']; ?>" />
        <br> email:<br>
	<input type="email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
        <br>Дата рождения:<br>
	<input type="date" name="date" <?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date']; ?>" />
	<br>Пол:<br> 
      	<div <?php if ($errors['pol']) {print 'class="error"';} ?>>
        <input type="radio" name="pol" value="man" <?php if ($values['pol'] == 'man') {print 'checked';} ?>> Муж
        <input type="radio" name="pol" value="woman" <?php if ($values['pol'] == 'woman') {print 'checked';} ?>> Жен
      </div>
		<br>
	Количество конечностей:
		 <div <?php if ($errors['parts']) {print 'class="error"';} ?>>
	<input type="radio" name="parts" value="1" <?php if ($values['parts'] == '1') {print 'checked';} ?>> 1 
        <input type="radio" name="parts" value="2" <?php if ($values['parts'] == '2') {print 'checked';} ?>> 2 
        <input type="radio" name="parts" value="3" <?php if ($values['parts'] == '3') {print 'checked';} ?>> 3 
        <input type="radio" name="parts" value="4" <?php if ($values['parts'] == '4') {print 'checked';} ?>> 4  
      </div>
	Сверхспособности:
	<br>
        <select name="abilities[]" multiple="true">
		<option value="immortality" <?php if (in_array("immortality", $values['abilities'])) {print 'selected';} ?>>Бессмертие</option>
		<option value="intangibility" <?php if (in_array("intangibility", $values['abilities'])) {print 'selected';} ?>>Прохождение сквозь стены</option>
		<option value="levitation" <?php if (in_array("levitation", $values['abilities'])) {print 'selected';} ?>>Ливитация</option>
        </select>
	<br>
	Биография:
	<br>
        <textarea name="biography" style="margin: 0px; height: 69px; width: 180px;"><?php print $values['biography']; ?></textarea>
      	</label>
	<br>
      	<label>
    	<input id="checkbox" type="checkbox" name="checkbox" onchange="document.getElementById('submit').disabled = !this.checked;" /> 
		С контрактом ознакомлен(а)
		<br>
		</label>
		<input type="submit" disabled="disabled" name="submit" id="submit" value="Отправить" />
		<br>
    </form>
	 <img src="putty.png" alt="PuTTY">
</body></html>