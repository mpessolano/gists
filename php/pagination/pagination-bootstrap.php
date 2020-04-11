<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<title>Paginación Bootstrap</title>
</head>
<body>

	<div class="container">

		<h2 class="mt-4 mb-4">Paginación</h2>

		<?php
			date_default_timezone_set('America/Caracas');

			try {
				$base = new PDO("mysql:host=localhost; dbname=dev-code", "root", "");

				$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$base->exec("SET CHARACTER SET utf8");

				$rows = isset($_GET['rows']) ? $_GET['rows'] : 10; // Registros por pagina

				$page = isset($_GET['page']) ? $_GET['page'] : 1; // Número de página actual

				$saltear = ($page-1) * $rows; // Calcular offset (desplazamiento)

				$sql_total = "SELECT id, nombreEs FROM cursos";

				$resultado = $base->prepare($sql_total);

				$resultado->execute([]);

				$records = $resultado->rowCount(); // Total de registros de la consulta

				$total = ceil($records/$rows); // Total de paginas de la paginación

				$resultado->closeCursor();

				$sql_limite = "SELECT id, nombreEs FROM cursos LIMIT $saltear, $rows";

				$resultado = $base->prepare($sql_limite);

				$resultado->execute([]);
			}
			catch (Exception $e)
			{
				echo "Línea de error: ".$e->getLine();
			}
		?>

		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th scope="col">Id</th>
					<th scope="col">NombreEs</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)):
				?>
				<tr>
					<td><?php echo $registro['id']; ?></td>
					<td><?php echo $registro['nombreEs'] ?></td>
				</tr>
				<?php
				endwhile;
				?>
				<?php
				if ($resultado->rowCount() <= 0):
					echo "<tr><td colspan='2'>No hay datos disponibles</td></tr>";
				endif;
				?>
			</tbody>
		</table>

		<?php
		//------------------------- INICIO PAGINACIÓN --------------------------
		if ($page>=1 && $page<=$total):
		?>
		
		<!-- =============================================================== -->
		<!-- PAGINACIÓN SIMPLE -->
		<nav aria-label="Page navigation" class="mt-4 mb-3">
			<ul class="pagination justify-content-center">
				<?php
				for ($i=1; $i<=$total ; $i++):
				?>
				<li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php
				endfor;
				?>
			</ul>
		</nav>

		<!-- =============================================================== -->
		<!-- PAGINACIÓN SIMPLE -->
		<nav aria-label="Page navigation" class="mt-4 mb-4">
			<ul class="pagination justify-content-center">
				<li class="page-item <?php echo ($page<=1) ? 'disabled' : ''; ?>">
					<a class="page-link" href="?page=<?php echo $page-1; ?>" tabindex="-1" aria-disabled="true">Anterior</a>
				</li>

				<?php
				for ($i=1; $i<=$total ; $i++):
					if ($i == $page):
					?>
					<li class="page-item active" aria-current="page">
						<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?> <span class="sr-only">(current)</span></a>
					</li>
					<?php
					else:
					?>
					<li class="page-item">
						<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
					</li>
					<?php
					endif;
				endfor;
				?>

				<li class="page-item <?php echo ($page>=$total) ? 'disabled' : ''; ?>">
					<a class="page-link" href="?page=<?php echo $page+1; ?>">Siguiente</a>
				</li>
			</ul>
		</nav>

		<!-- =============================================================== -->
		<!-- PAGINACIÓN ADVANCED -->
		<?php
		$adjacents = 2;

		//Here we generates the range of the page numbers which will display.
		if ($total <= (1 + ($adjacents * 2)))
		{
			$start = 1;
			$end   = $total;
		}
		else
		{
			if (($page - $adjacents) > 1)
			{ 
				if (($page + $adjacents) < $total)
				{ 
					$start = $page - $adjacents;            
					$end   = $page + $adjacents;         
				}
				else
				{             
					$start = $total - (1 + ($adjacents * 2));  
					$end   = $total;               
				}
			}
			else
			{               
				$start = 1;                                
				$end   = 1 + ($adjacents * 2);             
			}
		}
		?>
		<nav aria-label="Page navigation" class="mt-4 mb-4">
			<ul class="pagination pagination-sm justify-content-center">

				<!-- Link of the first page -->
				<li class='page-item <?php echo ($page<=1) ? 'disabled' : ''; ?>'>
					<a class='page-link' href='?page=1'>&#8249;</a>
				</li>

				<!-- Link of the previous page -->
				<li class="page-item <?php echo ($page<=1) ? 'disabled' : ''; ?>">
					<a class="page-link" href="?page=<?php echo ($page<=1) ? 1 : $page-1; ?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span><!-- &#171;-->
					</a>
				</li>

				<!-- Links of the pages with page number -->
				<?php
				for ($i=$start; $i<=$end ; $i++):
				?>
					<li class="page-item <?php echo ($i==$page) ? 'active' : ''; ?>" <?php echo ($i==$page) ?' aria-current="page"' : ''; ?>>
						<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?>
							<?php if ($i==$page): ?>
								<span class="sr-only">(current)</span>
							<?php endif; ?>
						</a>
					</li>
				<?php
				endfor;
				?>

				<!-- Link of the next page -->
				<li class="page-item <?php echo ($page>=$total) ? 'disabled' : ''; ?>">
					<a class="page-link" href="?page=<?php echo ($page>=$total) ? $total : $page+1; ?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>

				<!-- Link of the last page -->
				<li class="page-item <?php echo ($page>=$total) ? 'disabled' : ''; ?>">
					<a class="page-link" href="?page=<?php echo $total; ?>">&#8250;</a>
				</li>

			</ul>
		</nav>
		<!-- =============================================================== -->

		<?php
			echo "Mostrando la página {$page} de {$total} <br><br>";
			echo "Número de registros de la consulta: {$records}<br>";
			echo "Mostramos {$rows} registros por página <br><br>";

		endif;
		//--------------------------- FIN PAGINACIÓN ---------------------------
		?>

	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>	
</body>
</html>