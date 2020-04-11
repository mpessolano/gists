<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Paginación Simple</title>
</head>
<body>

<?php
	date_default_timezone_set('America/Caracas');

	try {
		$base = new PDO("mysql:host=localhost; dbname=dev-code", "root", "");

		$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$base->exec("SET CHARACTER SET utf8");

		$rows = isset($_GET['rows']) ? $_GET['rows'] : 20; // Registros por pagina

		$page = isset($_GET['page']) ? $_GET['page'] : 1; // Número de página actual

		$saltear = ($page-1) * $rows; // Calcular offset (desplazamiento)

		$sql_total = "SELECT id, nombreEs FROM cursos";

		$resultado = $base->prepare($sql_total);

		$resultado->execute([]);

		$records = $resultado->rowCount(); // Total de registros de la consulta

		$total = ceil($records/$rows); // Total de paginas de la paginación

		echo "Número de registros de la consulta: {$records}<br>";
		echo "Mostramos {$rows} registros por página <br>";
		echo "Mostrando la página {$page} de {$total} <br><br>";

		$resultado->closeCursor();

		$sql_limite = "SELECT id, nombreEs FROM cursos LIMIT $saltear, $rows";

		$resultado = $base->prepare($sql_limite);

		$resultado->execute([]);

		while ($registro = $resultado->fetch(PDO::FETCH_ASSOC))
		{
			echo "id: {$registro['id']} &#8594; nombreEs: {$registro['nombreEs']}<br>";
		}
	}
	catch (Exception $e)
	{
		echo "Línea de error: ".$e->getLine();
	}

	//------------------------------- PAGINACIÓN -------------------------------

	echo "<br>";

	for ($i=1; $i<=$total ; $i++)
	{
		echo "<a href='?page={$i}'>{$i}</a> ";
	}
?>
	
</body>
</html>