<?php

$connection = mysqli_connect(
            $config['db']['server'],
			$config['db']['username'],
			$config['db']['password'],
			$config['db']['name']
        );
if ($connection == false)
{
	echo "Не вдалось підключитись до Бази Даних!<br>";
    echo mysqli_connect_error();
	exit();
}
?>