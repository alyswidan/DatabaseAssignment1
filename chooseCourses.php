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
		<?php echo "<h1>Welcome {$_SESSION['username']} ,select some courses</h1>"?>
		<table class="table table-hover" id="courses">
			<thead> 
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Credi hours</th>
					<th>Choose course</th>
				</tr>
			</thead>
			<tbody>
				<?php
				spl_autoload_register(function ($class_name) {
					include $class_name . '.php';
				});
				$conn = new DbConnection('SRF');
				$courseManager = new CourseManager($conn);
				$userManager = new UserManager($conn);
				$loggedin_user = $userManager->getById($_SESSION['id']);
				$courses = $courseManager->getByDepartmentId($loggedin_user->department_id);	foreach ($courses as $course) {
					echo "<tr id={$course->id}>";
					echo "<td class='name'>{$course->name}</td>";
					echo "<td class='desc'>{$course->description}</td>";
					echo "<td class='credit-hours'>{$course->credit_hours}</td>";

					echo '<td class="add-course"><span>
					<span class="btn btn-xs btn-default select-course">
						<span class="glyphicon glyphicon-plus  select-course" ></span>
					</span>
				</span></td>';

				echo "</tr>";
			}

			?>
		</tbody>
	</table>
	<hr/>
	<h3>Selected courses</h3>
	<ul class="list-group" id="choosen-courses">
	</ul>
</div>

<script type="text/javascript">


$('#courses').click((e)=> {
	if($(e.target).hasClass('select-course'))
		{	
			let row = $($(e.target).closest('tr')[0]); 
			let btn = $($(e.target).closest('.btn')[0]);
			let item_id = row.attr('id');
			let name = row.find('.name').text();
			if(!btn.hasClass('disabled')){
				btn.addClass('disabled');
			$("#choosen-courses").append(` 
			<a class="list-group-item clearfix" id=${item_id}>
				${name}
				<span class="pull-right">
					<span class="btn btn-xs btn-default remove-course">
						<span class="glyphicon glyphicon-minus remove-course" ></span>
					</span>
				</span>
			</a>`)
			}
			

		}
})

	$('#choosen-courses').click((e)=> {
		if($(e.target).hasClass('remove-course'))
		{	
			let remove_anchor = $($(e.target).closest('a')[0]); 
			let item_id = remove_anchor.attr('id')
			remove_anchor.remove();
			$(`tr#${item_id}  .btn`).removeClass('disabled');

		}
	});




</script>

</body>
</html>