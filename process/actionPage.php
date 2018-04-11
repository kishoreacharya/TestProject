<?php

require_once '../config/DBConnection.php';

if($_REQUEST['formType']=='addUser'){  /* Add new user */
  $username=$_REQUEST['username'];
  if(!empty($_REQUEST['comapny'])){
    $comapnyId=$_REQUEST['comapny'];
  }
  $stmt = $conn->prepare("INSERT INTO users (username,company_id)
    VALUES(:field1,:field2)");
  $res = $stmt->execute(array(
    "field1" => $username,
    "field2" => $comapnyId               
  ));

}


if($_REQUEST['formType']=='addCompany'){  /* Add new Company */
  $companyname=$_REQUEST['companyname'];
  $stmt = $conn->prepare("INSERT INTO company (companyName)
    VALUES(:field1)");

  $res = $stmt->execute(array(
    "field1" => $companyname                
  ));
}


if($_REQUEST['formType']=='addUserToCompany'){  /* Add user to Company */
  $user_id=$_REQUEST['users'];
  $company_id=$_REQUEST['comapny'];
  $stmt = $conn->prepare("UPDATE users SET company_id=? WHERE id=?");
  $stmt->execute(array($company_id, $user_id));
  $affected_rows = $stmt->rowCount();
  if(!empty($affected_rows)){
    echo 'updated';
  }
}


if($_REQUEST['formType']=='companyList'){ /* Fetch all companies and list in drop list */ 
  $sql = "SELECT * FROM company";
  $stmt = $conn->query($sql);
  echo "<select name='comapny' id='comapny'>";
  echo "<option value=''>Select Company</option>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='".$row['id']."'>".$row['companyName']."</option>";
  }
  echo "</select>";  
}


if($_REQUEST['formType']=='usersList'){ /* Fetch all users associated to company */ 
  $company_id=$_REQUEST['company_id'];
  $sql = "SELECT * FROM users where company_id=".$company_id;
  $stmt = $conn->query($sql);
  $check_row = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!empty($check_row)){
    $sql = "SELECT * FROM users where company_id=".$company_id;
    $stmt = $conn->query($sql);

    echo "<br>Employee list: ";
    echo "<br>";
    echo "<br>";
    echo "<div class='container_list'>";
    echo "<div class='table'>";
    echo "<div class='table-content'>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $user_id=$row['id'];
      $anchorId='deleteUser'.$user_id;
      echo "<div class='table-row'>";
      echo "&nbsp;&nbsp;&nbsp;".$row['username'];

      echo "<span class='span_desc'><a href='#' id='$anchorId' data-toggle='modal' data-id='$user_id'>[Remove]</a>&nbsp;&nbsp;&nbsp;
      <br /><br />
      </span>
      </div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }else{
    echo "No users found";
  }
}

if($_REQUEST['formType']=='listUsers'){   /* Fetch all users and list in drop list */ 
  $sql = "SELECT * FROM users where company_id IS NULL";
  $stmt = $conn->query($sql);
  echo "<select name='users' id='users'>";
  echo "<option value=''>Select Users</option>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='".$row['id']."'>".$row['username']."</option>";
  }
  echo "</select>"; 
}


if($_REQUEST['formType']=='deleteUser'){   /* delete user from company */
  $id=$_REQUEST['user_id'];
  $comapny_id=NULL;
  $stmt = $conn->prepare("UPDATE users SET company_id=? WHERE id=?");
  $stmt->execute(array($comapny_id, $id));
  $affected_rows = $stmt->rowCount();
  if(!empty($affected_rows)){
    echo 'deleted';    
  }
}


?>
