form page<?php echo microtime(true);?><br />
<?php echo $title;?>

<form action="/test/action" id="" name="" method="POST">
	<input type="text" name="name" value="" /><br />
	<input type="text" name="na^&" value="" /><br />

	<input type="text" name="item[key1]" value="" /><br />
	<input type="text" name="item[key2]" value="" /><br />
	<input type="text" name="item[key3]" value="" /><br />
	<input type="text" name="item[key3][dd]" value="" /><br />
	<input type="checkbox" name="check[]" value="1" /><br />
	<input type="checkbox" name="check[]" value="2" /><br />
	<textarea name="text"></textarea><br />
	<input type="file" name="file"><br />

	<input type="submit" />
</form>