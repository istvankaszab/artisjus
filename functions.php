<?

function date_from_integer($days) {
	$pluszNapok = $days - 2 . ' days';
	$date = date_create('1900-01-01');
	date_add($date, date_interval_create_from_date_string($pluszNapok));
	return date_format($date, 'Y-m-d');
}

?>