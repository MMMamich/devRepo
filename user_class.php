<?php

// In SQL create a user table with feilds for id, name, email, group_id, address_id

$userTable = "CREATE TABLE Users (
    `id` INT NOT NULL PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `group_id` INT NOT NULL,
    `address_id` INT NOT NULL,
    FOREIGN KEY(group_id) REFERENCES Group(id),
    FOREIGN KEY(address_id) REFERENCES Address(id)
);";

// Create a group table and address tables include keys to the user table so that join select statements can be done.

$groupTable = "CREATE TABLE Groups (
    `group_id` INT NOT NULL PRIMARY KEY,
    `user_id` INT NOT NULL,
    FOREIGN KEY(`user_id`) REFERENCES Users(`id`)
);";

$addressTable = "CREATE TABLE Address (
    `address_id` INT NOT NULL PRIMARY KEY,
    `group_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    FOREIGN KEY(`group_id`) REFERENCES Groups(`group_id`),
    FOREIGN KEY(`user_id`) REFERENCES Users(`id`)
);";

// If there are PHP keywords here that you don't understand, Google it.

// `` are column names
// '' are values

class fill_user_list_variables($args,$group=null, $order=null) {
	extract($args);  // What does extract do?
                     //Extracts keys from an associative array and stores them as local variables so you can use their values

  $where_sql = "";
  $sort_sql = "";
  $from_sql = "";
  $search_sql = "";
  $param_array = array("a" => $args, "b" => $group, "c", => "order");

  // assume that this sets up the database correctly.
  $db = new PDO("config string");
  // $group, $order, $dir, $q - these are the optional variable that may be passed in.
  //select all rows and columns form a table called users.
  $from_sql+= "SELECT * FROM Users;";
      
  // select the `name` of all the users in 'guest'. `group` if a group variable to be passed to func and set to guest. Assume a $group variable passed in.
  
  "SELECT `Users.name` FROM Users;";
  "SELECT `Users.guest`FROM Users;"; //If $group arg is passed in
  
  // Place the selection into a variable $select_sql.  Use conditionals and add to the $where_sql variable.
      
  $select_sql = "SELECT `Users.name` FROM Users;";
    
  if($group==TRUE){  //Assuming Truthy value is put in 
        $group = "ALTER TABLE Users CHANGE `name` `guest` VARCHAR(50) NOT NULL;";
        "SELECT `Users.guest`FROM Users, Groups"
		$where_sql += "WHERE userTable.group_id = groupTable.user_id;";
	}else{
		echo "Incorrect Value";
	};

  // sort the results by `number_of_files` largest to smallest, make it possible to sort smallest to largest.  Assume a $order and $dir variable - put in $sort_sql
    
  //order can be either ASC or DESC, defaults to desc
  $order = "DESC";
  $sort_sql = $from_sql."ORDER BY ".$order;
    
  // Do a text search for a partial name - put in $search_sql
  $search_sql = $from_sql."WHERE ('name' LIKE '____' OR
  'name' LIKE '___' OR 'name' LIKE '__' OR 'name' LIKE '_');";

  // combine partial sql stmts into $sql_stmt_st
  $sql_stmt_st = $from_sql.$search_sql;

  // make the statment - this prepares and executes the statement.
  $sql_stmt = $db->prepare($sql_stmt_st);
  $sql_stmt->execute($param_array);

  $result = $sql_stmt->fetch(); // Use in a loop - this returns one result at a time until
    
  foreach($result as $key=>$value){
      return $key."=>".$value;
  }

  // return an array of associtive arrays of all users.
}

class add_user($args){
  extract($args);
	// Insert a row into the user table.  Data -> username, Full Name, email, group id
    $insert = "INSERT INTO User (`username`, `name`, `email`, `group_id`), VALUES ('rickyBobby123', 'Ricky Bobby', 'rickyBobby@gmail.com' '1');)";
  return json_ecncode(array('error'=>0, 'msg'=>$insert));
}

 ?>
