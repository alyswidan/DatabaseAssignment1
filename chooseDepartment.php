<?php
session_start();

?>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

</head>
<body>	

	<div class="container">      
		<?php echo "<h1>Welcome {$_SESSION['username']} ,select your department</h1>"?>
		<table class="table table-hover" id="departments">
			<thead> 
				<tr>
					<th>Name</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php
				spl_autoload_register(function ($class_name) {
					include $class_name . '.php';
				});
				$conn = new DbConnection('SRF');
				$deptManager = new GenericEntityManager($conn,'departments',new Department());
				$depts = $deptManager->getAll();

				foreach ($depts as $dept) {
					echo "<tr id={$dept->id}>";
					echo "<td>{$dept->name}</td>";
					echo "<td>{$dept->description}</td>";
					echo "</tr>";
				}

				?>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		$('#departments tr').on('click',function() {
			$.ajax({
				method: "POST",
				url: "userRequestHandler.php",
				data: { dept_id:this.id }
			})
			.done(function( msg ) {
				console.log(msg);
				if(msg.search('1') > 0){
					window.location = './chooseCourses.php'
				}
			});
		});



	</script>

</body>
</html>