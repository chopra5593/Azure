<html>
<head>
<Title>Registration Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Search the registration list</h1>
    <p>Fill in your name,  email address and company name then click <strong>Submit</strong> to register.</p>
<form method="post" action="search.php" enctype="multipart/form-data" >
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      Company Name <input type="text" name="company_name" id="company_name"/></br>
      <input type="submit" name="submit" value="Search" />
</form>
<?php
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    $host = "eu-cdbr-azure-west-b.cloudapp.net";
    $user = "bb78288a56ca98";
    $pwd = "cb4d9dca";
    $db = "amanchopradb";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Insert registration info
    if(!empty($_POST)) {
      try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date = date("Y-m-d");
        $company_name = $_POST['company_name'];
        // Search data
        $sql_search = "SELECT * FROM registration_tbl WHERE name LIKE ? AND email LIKE ? AND company_name LIKE ?";
        $stmt = $conn->prepare($sql_search);
        $stmt->bindValue(1, $name.'%');
        $stmt->bindValue(2, $email.'%');
        $stmt->bindValue(3, $company_name.'%');
        $stmt->execute();
      }
      catch(Exception $e) {
        die(var_dump($e));
      }
    }
    // Retrieve data
    $registrants = $stmt->fetchAll(); 
    if(count($registrants) > 0) {
        echo "<h2>Results found:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Date</th>";
        echo "<th>Company Name</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['name']."</td>";
            echo "<td>".$registrant['email']."</td>";
            echo "<td>".$registrant['date']."</td>";
            echo "<td>".$registrant['company_name']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No results found.</h3>";
    }
?>
</body>
</html>
