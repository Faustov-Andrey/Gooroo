<?php
	require_once ('cMenu.php');
	//phpinfo(); exit;
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<title>   ***   GooRoo   ***   decision making help   ***   </title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</HEAD>
	<BODY>
		<table width=100% border=1 cellspacing=4 cellpadding=4>
			<tr>
				<td>
					<center><img src=gooroo.jpg width=200 height=60></center>
				</td>
				<td>
					<center>
						<p><FONT SIZE="3" FACE="Courier New" COLOR="Black">decision making help</FONT></p>
					</center>
				</td>
				<td>
					<center><p>Banners and indicators</p></center>
				</td>
			</tr>
			<tr>
				<td>
					<center>?</center>
				</td>
				<td><center>
					
<div id="menu">
	<table width=100% border=1 cellspacing=2 cellpadding=2><tr>
	<ul>
		<?php
			foreach ($items as $item) 
			{
				echo "<td><center>";
				if (!$item["parent_menu_id"]) echo printItem($item, $items, $childrens); // Output elements of upper level
				echo "</center></td>";
			}
		?>
	</ul>
	</tr></table>
</div>	
				  
				</center></td>
				<td>
					<center><p>search</p></center>
				</td>
			</tr>