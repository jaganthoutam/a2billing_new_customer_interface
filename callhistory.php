<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Call On Fly::Call History';

//include header template
require('layout/header_man.php'); 
?>
<?php 

$id = $_SESSION['id']; 

$today = date('Y-m-d', time());


?>

<!-- START HERE -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>

<META HTTP-EQUIV="refresh" CONTENT="120">

<div class="container">
	<div class="row">        
        <div class="col-md-12">
        <h4>Customer Calls History</h4>
        <div class="table-responsive">

<form class="navbar-form navbar-left" role="search">
<div class="form-group">
<label>Phone Number Search</label>   
    <input name="callerid" type="text" class="form-control" placeholder="Search" id="callerid">
<label>Date Search</label>
  <input class="date" name="fromdate" type="date" placeholder="Start Date"  id="fromdate">
  <input class="date" name="todate" type="date" placeholder="End Date"  id="todate">
 </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<?php
$allowd = "WHERE t1.starttime >= ('$today') AND t1.starttime <= ('$today 23:59:59') AND t1.card_id='$id'";

if (!empty($_GET["callerid"])) {

$phonenumber = $_GET["callerid"];

$allowd = "where t1.dnid like '%$phonenumber' AND t1.card_id='$id' order by id desc";

$date = true;

}

if (!empty($_GET["fromdate"]) && !empty($_GET["todate"] )) {

$startdate = $_GET["fromdate"];
$enddate   = $_GET["todate"];

$allowd = "where t1.starttime >= ('$startdate') AND t1.starttime <= ('$enddate 23:59:59') AND t1.card_id='$id' order by id asc";

$date = true;

}

$sql = "SELECT count(*) as count FROM cc_call t1 $allowd";

$result = $conn->query($sql);

$totalrecords = $result->fetch_object()->count;

$adjacents = 5;
$targetpage = "callhistory.php"; //your file name
$limit = 20; //how many items to show per page
$page = $_GET['page'];

if($page){
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}


$targetpage = "callhistory.php?callerid=$phonenumber&fromdate=$startdate&todate=$enddate";

$allowd = $allowd . " LIMIT $start, $limit";

$sql = "SELECT * FROM cc_call t1 $allowd";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

?>
                
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead>
<!--				   <th>ID </th> -->
					         
                                   <th>Destination</th>
	                           <th>CallerID</th>
                                   <th>PhoneNumber</th>
				   <th>Duration(Sec.)</th>
				   <th>Call Cost</th>
				   <th>Termination Reason</th>
				   <th>Call Type</th>	
                                   <th>Date</th>
				   </thead>
	   		 	<tbody>
<?php
while($row = $result->fetch_assoc()) { 

$callid                  =     $row["id"];                   
$src                     =     $row["src"];                  
$dnid                    =     $row["dnid"];               
$id_did                  =     $row["id_did"];               
$sipiax                  =     $row["sipiax"];              
$buycost                 =     $row["buycost"];              
$card_id                 =     $row["card_id"];              
$id_trunk                =     $row["id_trunk"];             
$stoptime                =     $row["stoptime"];             
$uniqueid                =     $row["uniqueid"];             
$sessionid               =     $row["sessionid"];            
$starttime               =     $row["starttime"];            
$destination             =     $row["destination"];          
$id_ratecard             =     $row["id_ratecard"];          
$sessionbill             =     $row["sessionbill"];          
$sessiontime             =     $row["sessiontime"];          
$nasipaddress            =     $row["nasipaddress"];         
$calledstation           =     $row["calledstation"];        
$id_tariffplan           =     $row["id_tariffplan"];        
$id_tariffgroup          =     $row["id_tariffgroup"];       
$real_sessiontime        =     $row["real_sessiontime"];     
$terminatecauseid        =     $row["terminatecauseid"];  
$id_card_package_offer   =     $row["id_card_package_offer"];
$class 			 =     "danger";
		if ($destination == '22551'|| $destination == '22661') 	{ 

		$destination 	= 'USA';
    		$dnid		= substr($dnid, 4);
		}

		if ($terminatecauseid == '1') { $terminatecauseid = "ANSWER"; $class = "success";}
		if ($terminatecauseid == '2') { $terminatecauseid = "BUSY";}
		if ($terminatecauseid == '3') { $terminatecauseid = "NOANSWER";}
		if ($terminatecauseid == '4') { $terminatecauseid = "CANCEL";}
		if ($terminatecauseid == '5') { $terminatecauseid = "CONGESTION";}
		if ($terminatecauseid == '6') { $terminatecauseid = "CHANUNAVAIL";}
		if ($terminatecauseid == '7') { $terminatecauseid = "DONTCALL";}
		if ($terminatecauseid == '8') { $terminatecauseid = "TORTURE";}
		if ($terminatecauseid == '9') { $terminatecauseid = "INVALIDARGS";}		
		    $sessionid	      = substr($sessionid,0,3); 	

?>
   <tr class = "<?php echo $class;?>">
    <td><?php echo $destination ;?></td>
    <td><?php echo $src ;?></td>
    <td><?php echo $dnid ;?></td>
    <td><?php echo $real_sessiontime ;?></td>
    <td><?php echo $sessionbill ;?></td>
    <td><?php echo $terminatecauseid ;?></td>
    <td><?php echo $sessionid ;?></td>
    <td><?php echo $starttime ;?></td>
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
$pagination.= "<li><a href=\"$targetpage&page=$prev\">prev</a></li>"; 
}

if ($lastpage < 7 + ($adjacents * 2)) 
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>"; 
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
$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>"; 
}
//in middle; hide some front and some back
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href=\"$targetpage&page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage&page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>"; 
}
//close to end; only hide early pages
else
{
$pagination.= "<li><a href=\"$targetpage&page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage&page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; 
$counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>"; 
}
}
}

//next button
if ($page < $counter - 1) 
$pagination.= "<li><a href=\"$targetpage&page=$next\">next</a></li>";
else
$pagination.= "";
$pagination.= "</ul></div>\n"; 
$pagination.= "</ul>\n";

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
