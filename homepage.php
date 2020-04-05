<?php
//Initalize the errors variable 
$errors = "";
//Connect to the database
$db = mysqli_connect("localhost", "root", "", "todo");
//Create message for when a user clicks submit
if (isset($_POST['submit'])) {
	#If the user presses submit but the task input is empty it will give an error message
	if (empty($_POST['task'])) {
		$errors = "You must fill in a task before submitting.";
	} else {
		#Otherwise, assign the task to the task server variable
		$task = $_POST['task'];
		#Creating our query variable
		$query = "INSERT INTO tasks (task) VALUES ('$task')";
		#Run the query we want
		mysqli_query($db, $query);
		header('Location: homepage.php');
	}
}


// delete task
if (isset($_GET['del_task'])) 
{
	$id = $_GET['del_task'];

	mysqli_query($db, "DELETE FROM tasks WHERE id=" . $id);
	header('Location: homepage.php');
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>To-Do List </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">To-Do List</h2>
	</div>
	<form method="post" action="homepage.php" class="input_form">
		<!----IF WE HAVE EXISTING ERRORS, when the user goes to do something, it will print them out----->
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn"><b>Add Task</b></button>
	</form>

	<!----This creates the table where we will store our tasks so that we can display them after we retrieve them from database--->
	<table>
		<thead>
			<tr>
				<th>No.</th>
				<th>Tasks</th>
				<th style="width: 60px;">Action</th>
			</tr>
		</thead>

		<tbody>
			<?php
			# select all tasks if page is visited or refreshed
			$tasks = mysqli_query($db, "SELECT * FROM tasks");
			# Creates the counter which will be the task number starting at 1
			$i = 1;
			while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td class="task"> <?php echo $row['task']; ?> </td>
					<td class="delete">
						<a href="homepage.php?del_task=<?php echo $row['id'] ?>">x</a>
					</td>
				</tr>
			<?php ++$i;
			} ?>
		</tbody>
	</table>
</body>

</html>