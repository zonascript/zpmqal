<?php

// first approach
$sql  = "SELECT
  Student.id, 
  Student.name,
  Teacher.name AS teacher,
  subject.name AS subject
FROM
  Student
LEFT JOIN
  Student_Subject ON Student.id = Student_Subject.student_id
LEFT JOIN
  Teacher_Subject ON Student_Subject.subject_id = Teacher_Subject.subject_id
LEFT JOIN
  Teacher ON Teacher_Subject.teacher_id = Teacher.id
LEFT JOIN subject ON
  Student_Subject.subject_id = subject.id
WHERE
  Student.name = 'Vikram'";

$result = mysqlQuery($sql); // your custom function like using pdo or mysqli

$finalResult = [];
foreach ($result as $key => $value) {
	
	if (!isset($finalResult[$value['id']]['name'])) {
		$finalResult[$value['id']]['name'] = $value['name'];
	}

	$finalResult[$value['id']]['subjects_teacher'][] = [
			"teacher" => $value['teacher'],
			"subject" => $value['subject'],
		];
}

print_r($finalResult);


// second approach "not recommended"

$sql  = "SELECT
  Student.name,
  jt.subjects_teacher
FROM
  Student
LEFT JOIN (
	SELECT 
		ss.student_id,

		CONCAT('[',GROUP_CONCAT(CONCAT('{\"teacher\":\"', t.name,'\",\"subject\":\"', s.name, '\"}') ),']') AS subjects_teacher

	FROM `Student_Subject` ss 
	LEFT JOIN
	  Teacher_Subject ts ON ss.subject_id = ts.subject_id
	LEFT JOIN
	  Teacher t ON ts.teacher_id = t.id
	LEFT JOIN 
		subject s ON ss.subject_id = s.id
	GROUP BY ss.student_id
) jt ON jt.student_id = Student.id

WHERE
  Student.name = 'Vikram'";

$result = mysqlQuery($sql); // your custom function like using pdo or mysqli
foreach ($result as $key => &$value) {
	$value['subjects_teacher'] = json_decode($value['subjects_teacher'], true);
}

print_r($result);

exit;




function mysqlQuery($sql, $lastInsertId = false){
	try {
		$conn = new PDO("mysql:host=localhost;dbname=test;charset=utf8mb4", 'root', 'Goldfinch^1');
		$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$lastId = $conn->lastInsertId();
		$count=$stmt->rowCount();
		$data_array = [];

		if ($lastInsertId) {
			$data_array['lastInsertId'] = $lastId;
		};

		if($count>0){
			while($row = $stmt->fetch()) {
				$data_array[] = $row;			
			}
			return $data_array;
		}
		else{
			return FALSE;
		}

		
	}
	
	catch(PDOException $e) {
	  // $Error = 'SQL_ERROR:' . var_dump($e->getMessage());
	  return FALSE;
	}
}

$a = 'How are you?';

if (strpos($a, '(') !== false) {
    echo 'true';
}
echo '<br/>';


unlink('D:/OneDrive/FgfDrive/laravel5/public/images/activity/SG/Gardens_By_Bay/1 (1).jpg'); 
echo date('m/d/Y h:i:s A', time());
echo '<br/>';
echo date(DATE_ATOM,time());
$array = ["Lavel1" => "This is Lavel1", "LavelLoop" => []];
$array1 = ["Lavel2" => "This is Lavel2", "LavelLoop" => []];
$array2 = ["Lavel3" => "This is Lavel3", "LavelLoop" => []];
$array3 = ["Lavel3" => "This is Lavel3", "LavelLoop" => []];

$array2["LavelLoop"] = json_encode($array3);
$array1["LavelLoop"] = json_encode($array2);
$array["LavelLoop"] = json_encode($array1);

pre_echo($array);

$string = json_encode($array);
echo $string;
$d_array = json_decode($string,true);
$d_array['LavelLoop'] = json_decode($d_array['LavelLoop'], true);
$d_array['LavelLoop']['LavelLoop'] = json_decode($d_array['LavelLoop']['LavelLoop'], true);
$d_array['LavelLoop']['LavelLoop']['LavelLoop'] = json_decode($d_array['LavelLoop']['LavelLoop']['LavelLoop'], true);
pre_echo($d_array);

$string1 = fixNestedJson($string);
pre_echo(nested_jsonDecode($string1, true));
exit;
pre_echo($string1);
pre_echo(json_decode($string1),true);
exit;
$string1 = $string;

// $string1 = str_replace(['"{', '}"'], ['{', '}'], removeslashes($string));

pre_echo($string1);
pre_echo(nested_jsonDecode($string1, true));
echo '<br/>';

pre_echo(json_encode($d_array));

$text="My dog don\\\\\\\\\\\\\\\\'t like the postman!";
echo str_replace('\\', '', $text);

exit;



function fixNestedJson($string){
	return str_replace(['\\','"{', '}"'], ['','{', '}'],$string);
}

$array = nested_jsonDecode($json, true);

print_r($array);

function nested_jsonDecode($string, $is_array = true){
	return is_bool($is_array) 
					? json_decode(str_replace(['\\','"{', '}"'], ['','{', '}'],$string), $is_array) : '';
}

// function nested_jsonDecode($string, $is_array = true){
// 	$result = '';

// 	if (is_bool($is_array)) {
// 		// removing backslashe here
// 		$result = stripslashes(trim(implode("",explode("\\",$string))));

// 		// replacing double quotes here
// 		$result = str_replace(['"{', '}"'], ['{', '}'], $result);

// 		// making array or object here 
// 		$result = json_decode($result, $is_array);
// 	}

// 	return $result;
// }

function removeslashes($string)
{
    $string=implode("",explode("\\",$string));
    return stripslashes(trim($string));
}

function pre_echo($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

$array = ["b" => "b"];
unset($array["a"]);
print_r($array);

function example($a=0+1){
    echo "a = $a"; 
}

example(10);
example();

$dt = new DateTime();
$dt->setTimeZone(new DateTimeZone('UTC'));

$s = '2016-11-26T21:45+05:30';
$dt = new DateTime($s);

$date = $dt->format('m/d/Y');
$time = $dt->format('H:i');

echo $date, ' | ', $time;

$array = [
	["o" => "BOM", "d" => "SIN"],
	["o" => "SIN", "d" => "IJY"],
	["o" => "IJY", "d" => "MAL"] 
];

// echo foo($array);

function foo($array)
{
	$string = '';
	$i = 1;
	foreach ($array as $key => $value) {
		if ($i == 1) {
			$string .= $value['o'].'→'.$value['d'];
		}
		else{
			$string .= '→'.$value['d'];
		}
		$i++;
	}
	return $string;
}


?>