<?php 
 require_once("includes/header.php");
 require_once("includes/classes/Account.php");
 require_once("includes/classes/FormSanitizer.php");
 require_once("includes/classes/Constants.php");
$detailsMessage="";
$passwordMessage="";
 
?>
<?php

 if(isset($_POST["saveDetailButton"])){
     $account = new Account($con);

     $firstName =FormSanitizer::sanitizeFormString($_POST["firstName"]);
     $lastName =FormSanitizer::sanitizeFormString($_POST["lastName"]);
     $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

     if($account->updateDetails($firstName,$lastName,$email,$userLoggedIn)){
          $detailsMessage= "<div class='alertSuccess'>
                              Details updated successfully!
                              </div>";


     }
     else {
         $errorMessage = $account->getFirstError();

         $detailsMessage ="<div class='alertError'>
                               $errorMessage
                              </div>";
                              
     }



 }

 if(isset($_POST["savePasswordButton"])){
    $account = new Account($con);

    $oldPassword =FormSanitizer::sanitizeFormString($_POST["oldPassword"]);
    $newPassword =FormSanitizer::sanitizeFormString($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormEmail($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword,$newPassword,$newPassword2,$userLoggedIn)){
         $passwordMessage= "<div class='alertSuccess'>
                             Password updated successfully!
                             </div>";


    }
    else {
        $errorMessage = $account->getFirstError();

        $passwordMessage ="<div class='alertError'>
                              $errorMessage
                             </div>";
                             
    }



}
?>



<div class="passwordContainer column">
    <div class="formSection">
        <form action="" method="post">
         
            <?php

              $user = new User($con, $userLoggedIn);
              $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
              $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
              $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();


              

            ?>
            
            <h2>User Details</h2>
            <input type="text" name="firstName" placeholder=" First name" value="<?php echo $firstName ?>">
            <input type="text" name="lastName" placeholder=" Last name"value="<?php echo $lastName ?>">
            <input type="email" name="email" placeholder=" Email" value="<?php echo $email ?>">

            <div class="message">
            <?php echo $detailsMessage; ?>
            </div>

            <input type="submit" name="saveDetailButton" value ="save">

           

        </form>
    </div>


    <div class="formSection">
        <form action="" method="post">
         
            
            <h2>Update Password</h2>
            <input type="password" name="oldPassword" placeholder=" Old password">
            <input type="password" name="newPassword" placeholder=" New password">
            <input type="password" name="newPassword2" placeholder=" Confirm passsword">
              
            <div class="message">
            <?php echo $passwordMessage; ?>
            </div>
           
            <input type="submit" name="savePasswordButton" value ="save">

           

        </form>
    </div>

    <div class="formSection">
         <h2 >Subscription</h2>
         <?php 
         
          if($user->getIsSubscribed()){
              echo "<h3> You are subscribed! Go to Paypal to cancel.</h3>";
          }
          else{
              echo"<a href='billing.php'>Subscribe to Clone</a>";
          }
             
         
         ?>
    </div>
</div>