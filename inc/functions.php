
<?php

// NAVBAR GENERATOR
$navbar = [	 'Home'=>'home',
			 'Flight Details'=>'details',
			 'Order Flight' =>'order',
             'Log In'=>'login'];

function renderNav($navArray) {
	foreach ($navArray as $name=>$link):?> 
		<li><a href='?page=<?=$link?>'><?=$name?></a></li>
		<?php endforeach ?>

<?php
};

// MAILER

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
if (isset ($_POST['send']) || isset($_POST['feedback'])) {
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'kalafioras.serveriai.lt';              // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'send@ldauto.lt';                   // SMTP username
        $mail->Password = 'Testas123';        // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('send@ldauto.lt', 'Mailer');
        $mail->addAddress(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['name']));

        $mail->isHTML(true);                                  // Set email format to HTML
        if (isset ($_POST['send'])) {
            $mail->Subject = 'Problem from air_project';
        } else {
            $mail->Subject = 'Feedback from air_project';
        }
        $mail->Body    = htmlspecialchars($_POST['message']);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->send();
        header('Location:index.php');
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

// MYSQL DATABASE CONNECTION AND MANIPULATION ***********************

try {
    $conn = new PDO($dsn, $username, $password);
    $bestDeals = $conn->query("SELECT * FROM category JOIN flight ON category.id = flight.flight_category WHERE flight.flight_category = 1");
    $flightNames = $bestDeals->fetchAll(PDO::FETCH_ASSOC);
    $flightCategories = $conn->query("SELECT category.id, category.name FROM category");
    $categoryNames = $flightCategories->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e;
}

function generateDeals($flightNames) {
    foreach ($flightNames as $flightName):?>
    <?php $flightId = $flightName['id'];?>
       <div class="4u 12u$(medium)">
           <section class="box">
                <i class="icon big rounded color1 fa-cloud"></i>
                <h3><?=$flightName['name'] ?></h3>
                <p><?=$flightName['description'] ?></p>
                <form method='post'><button class="button small" name='flightInfo' value='<?=$flightId;?>'>Placiau</button></form>
           </section>
       </div>
    <?php endforeach;
}

function generateCategories($categoryNames, $connection) {
    foreach ($categoryNames as $categoryName):?>
    <?php $categoryId = $categoryName['id'];
    $flights = $connection->query("SELECT * FROM category JOIN flight ON category.id = flight.flight_category WHERE flight.flight_category = $categoryId");
    $flightsForCategory = $flights->fetchAll(PDO::FETCH_ASSOC) ?>
    <section id="one" class="wrapper style1 special">
        <div class='container'>
            <header class='major'>
                <h2><?=$categoryName['name'] ?></h2>
            </header>
            <div class='row 150%'>
                <?php generateDeals($flightsForCategory) ?>
            </div>
        </div>
    </section>
    <?php endforeach;
}

function generateFlightInfo($connection) {
    if(isset($_POST['flightInfo'])) {
        $post = $_POST['flightInfo'];
        $flightDetails = "SELECT * FROM flight WHERE id = :id";
        $flightDetailsPrepare = $connection->prepare($flightDetails);
        $flightDetailsPrepare->bindParam(':id', $post, PDO::PARAM_STR);
        $flightDetailsPrepare->execute();
        $fullFlightDetails = $flightDetailsPrepare->fetchAll(PDO::FETCH_ASSOC);?>
        <div class='container 50%'>
            <br>
            <h2>Name: <?=$fullFlightDetails[0]['name'] ?></h2>
            <h2>Description: <?=$fullFlightDetails[0]['description'] ?></h2>
            <h2>From: <?=$fullFlightDetails[0]['flight_from'] ?></h2>
            <h2>To: <?=$fullFlightDetails[0]['flight_to'] ?></h2>
            <h2>Price: <?=$fullFlightDetails[0]['price'] ?></h2>
            <br>
        </div>
        <?php 
    }
}

function displayFlights($connection) {
    $flights = $connection->query("SELECT * FROM flight");
    $flightArray = $flights->fetchAll(PDO::FETCH_ASSOC);
    foreach($flightArray as $flight) :?>
    <tr>
        <th scope='row'><?=$flight['id']?></th>
        <td><?=$flight['name']?></td>
        <td><?=$flight['description']?></td>
        <td><?=$flight['flight_from']?></td>
        <td><?=$flight['flight_to']?></td>
        <td><?=$flight['price']?></td>
        <td><?=$flight['flight_category']?></td>
        <td><a class='btn' name='delete' type="submit" href=?page=login&delete&id=<?=$flight['id']?>>
            <i class="fas fa-trash"></i></i></a></td>
        <td><a class='btn' name='edit' type="submit" href=?page=login&edit&id=<?=$flight['id']?>>
            <i class="fas fa-edit"></i></a></td>
    </tr>

    <?php endforeach;
}

function displayCategories($connection) {
    $cat = $connection->query("SELECT * FROM category");
    $catArray = $cat->fetchAll(PDO::FETCH_ASSOC);
    foreach($catArray as $cat) :?>
    <tr>
        <th scope='row'><?=$cat['id']?></th>
        <td><?=$cat['name']?></td>
    </tr>
    <?php endforeach;
}

if (isset($_POST['update'])) {
    updateFlightTable($conn, 'update');
} else if (isset($_POST['create'])) {
    updateFlightTable($conn, 'create');
} else if (isset($_GET['id']) && isset($_GET['delete'])) {
    deleteFromTable($conn);
}


// A D M I N     P A N E L    T A B L E S *****************************************

function updateFlightTable($connection, $changeType) {
    if (isset($_GET['id'])) { 
    	$flightId = $_GET['id'];
    }
    $flightName = $_POST['name'];
    $flightDesc = $_POST['description'];
    $flightFrom = $_POST['from'];
    $flightTo = $_POST['to'];
    $flightPrice = $_POST['price'];
    $flightCategory = $_POST['category'];
    $regexNumber = '/[0-9.]{1,8}/';
    $regexText = '/[a-zA-Z.,?!]{1,140}/';
    if ($changeType == 'update' && preg_match($regexNumber, $flightId) && preg_match($regexText, $flightName)
        && preg_match($regexText, $flightDesc) && preg_match($regexText, $flightFrom)
        && preg_match($regexText, $flightTo) && preg_match($regexNumber, $flightPrice)
        && preg_match($regexNumber, $flightCategory)) {
        $IdExistCheck = "SELECT * FROM flight WHERE id = :id";
        $IdExistCheckPrepare = $connection->prepare($IdExistCheck);
        $IdExistCheckPrepare->bindParam(':id', $flightId, PDO::PARAM_STR);
        $IdExistCheckPrepare->execute();
        if ($IdExistCheckPrepare->rowCount() > 0) {
            $flightDetails = "UPDATE flight SET name = :name, description = :description,
            flight_from = :flight_from, flight_to = :flight_to, price = :price,
            flight_category = :flight_category WHERE id = :id";
            $flightDetailsPrepare = $connection->prepare($flightDetails);
            $flightDetailsPrepare->bindParam(':id', $flightId, PDO::PARAM_STR);
            $flightDetailsPrepare->bindParam(':name', $flightName, PDO::PARAM_STR);
            $flightDetailsPrepare->bindParam(':description', $flightDesc, PDO::PARAM_STR);
            $flightDetailsPrepare->bindParam(':flight_from', $flightFrom, PDO::PARAM_STR);
            $flightDetailsPrepare->bindParam(':flight_to', $flightTo, PDO::PARAM_STR);
            $flightDetailsPrepare->bindParam(':price', $flightPrice, PDO::PARAM_STR);
            $flightDetailsPrepare->bindParam(':flight_category', $flightCategory, PDO::PARAM_STR);
            $flightDetailsPrepare->execute();
        } else {
            $message = "ID does not exist in database. Nothing to update.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else if ($changeType == 'create' && preg_match($regexText, $flightName)
        && preg_match($regexText, $flightDesc) && preg_match($regexText, $flightFrom)
        && preg_match($regexText, $flightTo) && preg_match($regexNumber, $flightPrice)
        && preg_match($regexNumber, $flightCategory)) {
        $flightDetails = "INSERT INTO flight (name, description, flight_from, 
            flight_to, price, flight_category) VALUES (:name, :description, :flight_from,
            :flight_to, :price, :flight_category)";
        $flightDetailsPrepare = $connection->prepare($flightDetails);
        $flightDetailsPrepare->bindParam(':name', $flightName, PDO::PARAM_STR);
        $flightDetailsPrepare->bindParam(':description', $flightDesc, PDO::PARAM_STR);
        $flightDetailsPrepare->bindParam(':flight_from', $flightFrom, PDO::PARAM_STR);
        $flightDetailsPrepare->bindParam(':flight_to', $flightTo, PDO::PARAM_STR);
        $flightDetailsPrepare->bindParam(':price', $flightPrice, PDO::PARAM_STR);
        $flightDetailsPrepare->bindParam(':flight_category', $flightCategory, PDO::PARAM_STR);
        $flightDetailsPrepare->execute();
    } else {
        $message = "Form filled incorrectly. Please try again.";
            echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

function deleteFromTable($connection) {
    $flightId = $_GET['id'];
    $IdExistCheck = "SELECT * FROM flight WHERE id = :id";
    $IdExistCheckPrepare = $connection->prepare($IdExistCheck);
    $IdExistCheckPrepare->bindParam(':id', $flightId, PDO::PARAM_STR);
    $IdExistCheckPrepare->execute();
    if ($IdExistCheckPrepare->rowCount() > 0) {
        $flightDetails = "DELETE FROM flight WHERE id = :id";
        $flightDetailsPrepare = $connection->prepare($flightDetails);
        $flightDetailsPrepare->bindParam(':id', $flightId, PDO::PARAM_STR);
        $flightDetailsPrepare->execute();
    } 
}

function updateForm($connection) {
    $flightId = $_GET['id'];
    $flightDetails = "SELECT * FROM flight WHERE id = :id";
    $flightDetailsPrepare = $connection->prepare($flightDetails);
    $flightDetailsPrepare->bindParam(':id', $flightId, PDO::PARAM_STR);
    $flightDetailsPrepare->execute();
    $fullFlightDetails = $flightDetailsPrepare->fetchAll(PDO::FETCH_ASSOC);?>
    <form method='post' class="form-horizontal form-label-left" novalidate>
      <span class="section">Editing Flight ID <?=$flightId;?></span>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input value='<?=$fullFlightDetails[0]["name"];?>' id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Type in the name for the flight" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input value='<?=$fullFlightDetails[0]["description"];?>' id="description" class="form-control col-md-7 col-xs-12" name="description" placeholder="Type in the description for the flight" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Flight From <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input value='<?=$fullFlightDetails[0]["flight_from"];?>' id="from" class="form-control col-md-7 col-xs-12" name="from" placeholder="Flight departure location" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Flight To <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input value='<?=$fullFlightDetails[0]["flight_to"];?>' id="to" class="form-control col-md-7 col-xs-12" name="to" placeholder="Flight destination" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Price <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input value='<?=$fullFlightDetails[0]["price"];?>' id="price" class="form-control col-md-7 col-xs-12" name="price" placeholder="Price of flight" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Category <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input value='<?=$fullFlightDetails[0]["flight_category"];?>' id="category" class="form-control col-md-7 col-xs-12" name="category" placeholder="Flight category" required="required" type="text">
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
          <button name='update' type="submit" class="btn btn-success">Update</button>
          <a style="color: #fff" class='btn btn-warning' href=?page=login>Cancel</a>
        </div>
      </div>
    </form> <?php 
}

function createNewForm() {
    ?>
    <form method='post' class="form-horizontal form-label-left" novalidate>
      <span class="section">Create New Flight</span>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Type in the name for the flight" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="description" class="form-control col-md-7 col-xs-12" name="description" placeholder="Type in the description for the flight" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Flight From <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="from" class="form-control col-md-7 col-xs-12" name="from" placeholder="Flight departure location" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Flight To <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="to" class="form-control col-md-7 col-xs-12" name="to" placeholder="Flight destination" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Price <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="price" class="form-control col-md-7 col-xs-12" name="price" placeholder="Price of flight" required="required" type="text">
        </div>
      </div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Category <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input id="category" class="form-control col-md-7 col-xs-12" name="category" placeholder="Flight category" required="required" type="text">
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
          <button name='create' type="submit" class="btn btn-danger">Create</button>
        </div>
      </div>
    </form> <?php 
}

