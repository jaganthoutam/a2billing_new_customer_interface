<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Call On Fly::Call Rates';

//include header template
require('layout/header_man.php'); 
?>
<?php 

$id = $_SESSION['id']; 
$rateplan = $_SESSION['tariff'];

$today = date('Y-m-d', time());


?>

<!-- START HERE -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>

<div class="container">
	<div class="row">        
        <div class="col-md-12">
        <h4>Customer Call Rates</h4>
        <div class="table-responsive">

<form class="navbar-form navbar-left" id="callerid" role="search">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Search">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

<?php

$sql = "select count(*) as count from cc_callplan_lcr where tariffgroup_id=$rateplan order by id desc";


$result = $conn->query($sql);

$totalrecords = $result->fetch_object()->count;

$adjacents = 5;
$targetpage = "rates.php"; //your file name
$limit = 10; //how many items to show per page
$page = $_GET['page'];

if($page){
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}


$sql = "select dialprefix,destination,rateinitial,initblock from cc_callplan_lcr where tariffgroup_id=$rateplan order by id desc LIMIT $start, $limit";

//echo $sql;

$result = $conn->query($sql);

if ($result->num_rows > 0) {

?>
                
<!--              <table id="mytable" class="table table-bordred table-striped">  -->
    <table class="table table-striped custab">

                   
                   <thead>
<!--				   <th>ID </th> -->
					         
                                   <th>Dial Prefix</th>
	                           <th>Destination</th>
                                   <th>Rate Initial</th>
				   <th>Billing Block</th>
				   </thead>
	   		 	<tbody>
<?php
while($row = $result->fetch_assoc()) { 

$dialprefix               	=     $row["dialprefix"];                   
$destination   			=     $row["destination"]; 
$rateinitial    		=     $row["rateinitial"];
$initblock        		=     $row["initblock"];

$class = "success";

?>
   <tr class = "<?php echo $class;?>">
    <td><?php echo $dialprefix ;?></td>
    <td><?php echo $destination ;?></td>
    <td><?php echo $rateinitial ;?></td>
    <td><?php echo $initblock ;?></td>
    </tr>  
    </tbody>
<?php } ?>        
</table>
<?php } 

//include pagination class which we have created
/**
$sql = "SELECT count(*) as count FROM cc_call t1 WHERE t1.starttime >= ('$today') AND t1.starttime <= ('$today 23:59:59') AND t1.card_id='$id'";


$result = $conn->query($sql);

$totalrecords = $result->fetch_object()->count;

$adjacents = 5;
$targetpage = "callhistory.php"; //your file name
$limit = 10; //how many items to show per page
$page = $_GET['page'];

if($page){ 
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}


/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($totalrecords / $limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1


$pagination = "";
if($lastpage > 1)
{ 
//$pagination .= "<div class='pagination'> <ul>";

$pagination .= "<div><ul class='pagination pull-right pagination-sm'>";


if ($page > $counter+1) {
$pagination.= "<li><a href=\"$targetpage?page=$prev\">prev</a></li>"; 
}

if ($lastpage < 7 + ($adjacents * 2)) 
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
{
//close to beginning; only hide later pages
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>"; 
}
//in middle; hide some front and some back
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>"; 
}
//close to end; only hide early pages
else
{
$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; 
$counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
}
}

//next button
if ($page < $counter - 1) 
$pagination.= "<li><a href=\"$targetpage?page=$next\">next</a></li>";
else
$pagination.= "";
$pagination.= "</ul></div>\n"; 
//$pagination.= "</ul>\n";

}

//echo $pagination; 

?>
  
<?php

echo $pagination;

?>             
 
</div>
            
</div>

</div>

</div>

</div>

<?php 
//include header template
require('layout/footer.php'); 
?>
