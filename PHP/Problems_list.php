<table id = "table_list" cellpadding = '7px' cellspacing = '2px'>				
	<tr>
		<th colspan = "3", style = "color:red;font-size:200%;">
			Listing Problems
		</th>
	</tr>
	<tr>
		<th>
			<p> Problem's ID </p>
		</th>
		<th>
			<p> Problem's Name </p>
		</th>
		<th>
			<p> Type </p>
		</th>	
	</tr>
	<?php
		include($directory_of_classes.'Listing_problems.php');
	?>
</table> 
<ul class = 'pagination'>
	<?php
		include($directory_of_classes.'Listing_pages_problems.php');
	?>
</ul>
