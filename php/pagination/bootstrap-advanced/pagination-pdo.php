<?php
include('paginator.class.php');

$db = new PDO("mysql:host=localhost; dbname=dev-code", "root", "");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("SET CHARACTER SET utf8");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>Paginación Bootstrap Avanzada</title>
</head>
<body>

	<div class="container">

		<h1 class="mt-5">Paginación avanzada con PDO</h1>

    	<hr>

		<?php
			$pages = new Paginator;
			$pages->default_ipp = 15;
			$sql_forms = $db->prepare("SELECT id, nombreEs FROM cursos");
			$sql_forms->execute([]);
			$pages->items_total = $sql_forms->rowCount();
			$pages->mid_range = 4;
			$pages->paginate();

			$sql_forms->closeCursor();

			$result = $db->prepare("SELECT id, nombreEs FROM cursos {$pages->limit}");

			$result->execute([]);
		?>
		<div class="clearfix"></div>
		
		<div class="row mt-4 mb-3">
			<div class="col-sm-12">
				<?php if ($pages->items_total > 0) { ?>
					<?php echo $pages->display_pages(); ?>
					<?php echo $pages->display_items_per_page(); ?>
					<?php echo $pages->display_jump_menu(); ?>
				<?php } ?>
			</div>
		</div>

		<div class="clearfix"></div>
		
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>NombreEs</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if ($pages->items_total > 0):
					while ($val = $result->fetch(PDO::FETCH_ASSOC)):
				?>
				<tr>
					<td><?php echo $val['id']; ?></td>
					<td><?php echo $val['nombreEs']; ?></td>
				</tr>
				<?php 
					endwhile;
				else:
				?>
				<tr>
					<td colspan="2" align="center"><strong>No Record(s) Found</strong></td>
				</tr>
				<?php 
				endif;
				?>
			</tbody>
		</table>
		
		<div class="clearfix"></div>
		
		<div class="row mt-4">
			<div class="col-sm-12">
				<?php if ($pages->items_total > 0) { ?>
					<?php echo $pages->display_pages(); ?>
					<?php echo $pages->display_items_per_page(); ?>
					<?php echo $pages->display_jump_menu(); ?>
				<?php }?>
			</div>
		</div>
        
    </div> <!--/.container-->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>	
</body>
</html>