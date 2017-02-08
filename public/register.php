<?php
  require_once('../private/initialize.php');
  require_once('../private/validation_functions.php');



if(is_post_request()) {
  // is a POST request

  $fn = $_POST['first_name'];
  $ln = $_POST['last_name'];
  $email = $_POST['email'];
  $un = $_POST['username'];



  $errMsgs = [];
  $hasErr = false;
  if(is_blank($fn)){
      $errMsgs[] = "First name must not be blank.";
      $hasErr = true;
  }
  elseif(!has_length($fn, ['min' => 2, 'max' => 255])){
      $errMsgs[] = "First name must be between 2 and 255 characters.";
      $hasErr = true;
  }
  if(is_blank($ln)){
      $errMsgs[] = "Last name must not be blank.";
      $hasErr = true;
  }
  elseif(!has_length($ln, ['min' => 2, 'max' => 255])){
      $errMsgs[] = "Last name must be between 2 and 255 characters.";
      $hasErr = true;
  }
  if(is_blank($un)){
      $errMsgs[] = "Username must not be blank.";
      $hasErr = true;
  }
  elseif(!has_length($un, ['min' => 8, 'max' => 255])){
      $errMsgs[] = "Username must be between 8 and 255 characters.";
      $hasErr = true;
  }
  if(is_blank($email)){
      $errMsgs[] = "Email must not be blank.";
      $hasErr = true;
  }
  elseif(!has_valid_email_format($email) || !has_length($email, ['min' => 2, 'max' => 255])){
      $errMsgs[] = "Please enter a valid email address.";
      $hasErr = true;
  }

  // Display errors if errors were caught
  if(!$hasErr){

        // SQL INSERT statement
        $sql = "INSERT INTO USERS (first_name, last_name, email, username, created_at)
                VALUES ('" . $fn . "', '". $ln . "', '". $email . "', '". $un . "', '" . date("Y-m-d H:i:s") ."');";

        $result = db_query($db, $sql);

        if($result) {
            db_close($db);
        }
        else {
          // The SQL INSERT statement failed.
          // Just show the error, not the form
          echo h(db_error($db));
          db_close($db);
          exit;
        }

        redirect_to("registration_success.php");

    }
}

    ?>
    <?php $page_title = 'Register'; ?>
    <?php include(SHARED_PATH . '/header.php'); ?>

    <div id="main-content">
      <h1>Register</h1>
      <p>Register to become a Globitek Partner.</p>

      <?php
      if($hasErr){
          echo display_errors($errMsgs);
      }
      ?>

      <!-- TODO: HTML form goes here -->

          <form action="register.php" method="post">
              <h4>First Name</h4>
              <input type="text" name="first_name" value="<?php echo h($fn); ?>" /><br />
              <h4>Last Name</h4>
              <input type="text" name="last_name" value="<?php echo h($ln); ?>" /><br />
              <h4>Email</h4>
              <input type="text" name="email" value="<?php echo h($email); ?>" /><br />
              <h4>Username</h4>
              <input type="text" name="username" value="<?php echo h($un); ?>" /><br />
              <br />
              <br />
              <input type="submit" name="submit" value="Submit" />
            </form>


    </div>

    <?php include(SHARED_PATH . '/footer.php'); ?>
