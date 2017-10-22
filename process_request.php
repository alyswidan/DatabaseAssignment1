<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$employee = Employee::fromProps($_POST['fName'],$_POST['lName'],$_POST['email'],$_POST['Dno']);
$conn = new DbConnection("lab2");
$employeManager = new GenericEntityManager($conn,"Emp",$employee);
$deptManger = new GenericEntityManager($conn,"Dept",new Department());

if ($employeManager->save($employee) === TRUE) {
 	var_dump($deptManger->getAll());

} else {
    echo "Error: "  . "<br>" . $conn->error();
}



unset($conn);
?>