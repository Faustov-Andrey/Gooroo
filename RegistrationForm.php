<!DOCTYPE HTML>
<HTML>
 <HEAD>
  <title>   ***   ИНТЕК-компьютеры   ***   Intech computers   ***   </title>
  <link rel="stylesheet" href="style.css" type="text/css">
 </HEAD>

 <BODY>
<?php include "top.php" ?> 
    <tr> 
      <td>
        <A HREF="catalog.php?fold=yes">[+]</A></A><A HREF="catalog.php?fold=yes"> Каталог</A>
      </td>
      <td>
         <form action="handler.php">
			<p>Имя <input type="text" size="32"><Br>
			<p>Фамилия<input type="text" size="32"><Br>
			<p>Отчество<input type="text" size="32"><Br>
			<p>Пол<input type="radio" name="answer" value="a1">Мужской
				     <input type="radio" name="answer" value="a2">Женский
				     <input type="radio" name="answer" value="a3">?</p>
			<p>Дата рождения:   год<input type="text" size="10">месяц<input type="text" size="10">число<input type="text" size="10"><Br>
			<p>Город<input type="text" size="10"><Br>
			<p>Улица<input type="text" size="10"><Br>
			<p>Дом<input type="text" size="10"><Br>
			<p>Квартира<input type="text" size="10"><Br>
			<p>Номер телефона стационарного<input type="text" size="10"><Br>
			<p>Номер телефона мобильного<input type="text" size="10"><Br>
			<p>Адрес электронной почты<input type="text" size="10"><Br>
			<p>Адрес вэбсайта<input type="text" size="10"><Br>
			<p>ИНН<input type="text" size="10"><Br>
			<p>КПП<input type="text" size="10"><Br>
			<p>ОГРН<input type="text" size="10"><Br>
			<p>Банк<input type="text" size="32"><Br>
			<p>БИК<input type="text" size="10"><Br>
			<p>Рассчётный счёт<input type="text" size="20"><Br>
			<p>Корреспондентский счёт<input type="text" size="20"><Br>
			<p><input type="submit" value="Зарегистрироваться"></p>
		</form>
      </td>
      <td>
        <center><p>Новости реклама и прочее</p></center>
      </td>
     </tr>
<?php include "bottom.php" ?> 

  </table>

 </BODY>
</HTML>
