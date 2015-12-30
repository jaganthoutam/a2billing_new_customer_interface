<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//echo $last_name;
//echo $e_mail;
//echo $id;



//define page title
$title = 'Call On Fly::User';

//include header template
require('layout/header_man.php'); 

if ( $_POST['first_name'] || $_POST['last_name'] || $_POST['e_mail'] ) {

echo $fname = $_POST['first_name'];
echo $lname = $_POST['last_name'];
echo $email = $_POST['e_mail'];
echo $id = $_POST['id'];

$sql = "UPDATE cc_card set firstname=$fname,lastname=$lname,email=$email where id=$id";
$result = $conn->query($sql);
if ($result == true) {
echo "<h2>Hello!! Results Updated</h2>"; 
}
else {
echo "<h2>Hello!! Results Not Updated</h2>";


}

}



?>

 <div class="container">
        <section style="padding-bottom: 50px; padding-top: 50px;">
            <div class="row">
                <div class="col-md-4">
                    <img src="assets/img/250x250.png" class="img-rounded img-responsive" />
                    <br />
                    <br />
                    <label>Registered Username</label>
	            <form action="userinfo.php" method="post">
	            <input type="text" class="form-control" placeholder="<?php echo $_SESSION['username']; ?>" disabled>
                    <label>Frist Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="<?php echo $_SESSION['firstname']; ?>">
		    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="<?php echo $_SESSION['lastname']; ?>">
                    <label>Registered Email</label>
                    <input type="text" name="e_mail" class="form-control" placeholder="<?php echo $_SESSION['email']; ?>">
                    <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
 		    <br>
                    <input id="submit" type="submit" class="btn btn-success" value="Update Details">
                    </form>
	            <br /><br/>

                </div>
                <div class="col-md-8">
                    <div class="alert alert-info">
                        <h2>Hello!!   : <?php echo $_SESSION['lastname'].''.$_SESSION['firstname'] ; ?> </h2>
                        <h4>UserID    : <?php echo $_SESSION['username']; ?> </h4>
			<h4>Account ID: <?php echo "4000".$_SESSION['id']; ?> </h4>
			<h4>Credit    : <?php echo "$".$_SESSION['credit']; ?> </h4>

<!--                        <p>
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
                        </p>  -->
</br>
</br>
</br>

                    </div>
                    <div class="form-group col-md-8">
                        <h3>Change YOur Password</h3>
                        <br />
                        <label>Enter Old Password</label>
                        <input type="password" name="oldpass" class="form-control">
                        <label>Enter New Password</label>
                        <input type="password" name="newpass" class="form-control">
                        <label>Confirm New Password</label>
                        <input type="password" name="newpass" class="form-control" />
                        <br>
                        <a href="#" class="btn btn-warning">Change Password</a>
                    </div>
                </div>
            </div>
            <!-- ROW END -->

<?php 
//include header template
require('layout/footer.php'); 
?>
