<?php
	
	// класс для работы с меню.
	class cMenu
	{
		// члены-переменные
		var $name;
		var $mItem = array();
		var $mItems = array(); // Массив для пунктов меню
		var $mChildrens = array(); // Массив для соответствий дочерних элементов их родительским
		
		// члены-методы:

		//************************************************************************************************
		/**
		* Запрашивает из базы дерево меню.
		*/
		function GetMenuItems() 
		{
			// Соединяемся, выбираем базу данных
			$link = mysql_connect("localhost", "faust", "Ioan")	or die("Could not connect : " . mysql_error());
			mysql_select_db("iNDocsnet") or die("Could not select database");

			//$mysqli = new mysqli("localhost", "faust", "Ioan"); // Подключаемся к БД
			//$result_set = $mysqli->query("SELECT * FROM `Menu`"); // Делаем выборку всех записей из таблицы с меню
		  
			// Выбираем идентификатор группы 
			$query = "SELECT * FROM `Menu`";
			$result = mysql_query($query) or die("Query failed : " . mysql_error());
			//$items = array(); // Массив для пунктов меню
			
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				$mItems[$line["menu_id"]] = $line; // Заполняем массив выборкой из БД
				//echo $line["parent_menu_id"]."   ";echo $line["menu_id"]."   ";echo $line["title"]."   ";echo $line["native_lang_title"]."   ";echo $line["link"]."   ";
			}
			//$mChildrens = array(); // Массив для соответствий дочерних элементов их родительским
			foreach ($mItems as $mItem) 
			{
				if ($mItem["parent_menu_id"] and !($mItem["parent_menu_id"] == 0)) $mChildrens[$mItem["menu_id"]] = $mItem["parent_menu_id"]; // Заполняем массив
				//echo "Item".$mItem["parent_menu_id"]."   ".$mItem["menu_id"]."   ".$mItem["title"]."   ".$mItem["native_lang_title"]."   ".$mItem["link"]."   ";
				//echo $mItems[$mItem["parent_menu_id"]]."   ".$mItems[$mItem["menu_id"]]."   ".$mItems[$mItem["title"]]."   ".$mItems[$mItem["native_lang_title"]]."   ".$mItems[$mItem["link"]]."   ";
				//echo "Childrens".$mChildrens[$mItem["parent_menu_id"]]."   ".$mChildrens[$mItem["menu_id"]]."   ".$mChildrens[$mItem["title"]]."   ".$mChildrens[$mItem["native_lang_title"]]."   ".$mChildrens[$mItem["link"]]."   ";
				
			}	
			return $mItems;
		}
		
		
		//************************************************************************************************
		/**
		* Выводим пункт меню на страницу.
		*/
		
		function printItems($pItem, $pItems, $pChildrens) 
		{	

			/* Выводим пункт меню */
			//echo "<li>";
			echo "<a href='".$pItem["link"]."'>".$pItem["native_lang_title"]."</a>";
			$ul = false; // Выводились ли дочерние элементы?
			while (true) 
			{
				/* Бесконечный цикл, в котором мы ищем все дочерние элементы */
				$key = array_search($pItem["menu_id"], $pChildrens); // Ищем дочерний элемент
				if (!$key) 
				{
					/* Дочерних элементов не найдено */
					if ($ul) echo "</ul>"; // Если выводились дочерние элементы, то закрываем список
					break; // Выходим из цикла
				}
				unset($pChildrens[$key]); // Удаляем найденный элемент (чтобы он не выводился ещё раз)
				if (!$ul) 
				{
					echo "<ul>"; // Начинаем внутренний список, если дочерних элементов ещё не было
					$ul = true; // Устанавливаем флаг
				}
				echo printItem($pItems[$key], $pItems, $pChildrens); // Рекурсивно выводим все дочерние элементы
			}
			//echo "</li>";
			
			foreach ($pItems as $pItem) 
			{
				echo "<td><center>";
				if (!$pItem["parent_menu_id"]) echo printItem($pItem, $pItems, $pChildrens); // Выводим все элементы верхнего уровня
				echo "Item".$pItem["parent_menu_id"]."   ".$pItem["menu_id"]."   ".$pItem["title"]."   ".$pItem["native_lang_title"]."   ".$pItem["link"]."   ";
				echo $pItems[$pItem["parent_menu_id"]]."   ".$pItems[$pItem["menu_id"]]."   ".$pItems[$pItem["title"]]."   ".$pItems[$pItem["native_lang_title"]]."   ".$pItems[$pItem["link"]]."   ";
				echo "Childrens".$pChildrens[$pItem["parent_menu_id"]]."   ".$pChildrens[$pItem["menu_id"]]."   ".$pChildrens[$pItem["title"]]."   ".$pChildrens[$pItem["native_lang_title"]]."   ".$pChildrens[$pItem["link"]]."   ";
				
				echo "</center></td>";
			}
			
		}
	}
	
		//************************************************************************************************
		/**
		* Выводим дерево меню на страницу.
		*/
		function ShowMenu() 
		{
			foreach ($mItems as $mItem) 
			{
				echo "<td><center>";
				if (!$mItem["parent_menu_id"]) echo printItem($mItem, $mItems, $mChildrens); // Выводим все элементы верхнего уровня
				echo "</center></td>";
			}
		}
?>
