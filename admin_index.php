<?php 
session_start();
error_reporting(0);
if($_SESSION['username']=='')
{
?>
<script language="javascript">
window.location="login.php";
</script>
<?php
}


include('database/db_conn.php');
$s_title="Index";
include('admin_header.php');
$t_res=mysql_query("select * from users where status!=1");
$total_user=mysql_num_rows($t_res);
$d_res=mysql_query("select * from domain_master where status!=1");
$total_domain=mysql_num_rows($d_res);
//echo "self". $_SERVER["PHP_SELF"];

//echo "Host Name : ".$host_name = $_SERVER['HTTP_HOST'];

		// Code to Broadcast Message from junkies : 28/3/2012 : Mitul
		$url="http://192.168.1.91/xampp/xhtmljunkies/broadcast_message.php";
		$key = array("system"=>'DMS');
		$ch = curl_init();
	
		// Set URL 
		curl_setopt($ch, CURLOPT_URL, $url);
	
		// Tell cURL to return the output 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $key);

		// Tell cURL NOT to return the headers 
		curl_setopt($ch, CURLOPT_HEADER, 0);
	
		// Execute cURL, Return Data 
		$data = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
		// Close cURL Resource 
		curl_close($ch);
	
		//End


?>
        

<div id="content_main" class="clearfix">
<div id="dashboard" style="width:100%">
				<h2 class="ico_mug">Dashboard</h2>
				<div class="clearfix">
				<div class="left quickview" style="width:100%; border-bottom:none; border-top:none;">
					<h3>Overview</h3>
					<ul>
					<li>Total Users: <span class="number"><?php echo $total_user;?></span></li>
					<li>Total Domain: <span class="number"><?php echo $total_domain;?></span></li>
					</ul>
				</div>
				<div style="margin:12px 0 0; border:1px solid #FFF; width:auto; background:#CCC;display:block;" id="message">
				<table style="width:auto;">
				<?php
				 
				if($data != '')
				  {
				  echo "<tr style='border:1px solid #FF0000;width:auto;'>";
                  echo "<td style='width:auto;padding:10px 0 10px 10px;'>".$data."</td>";
				  echo "<td onclick='display_message();'><span style='padding:11px 10px 0 10px;cursor:pointer'><img src='images/cancel.png'/></span></td>";
				  echo "</tr>";
                 }
                ?>
                </table>
                </div>
				</div>
			</div>
            <div id="shortcuts" class="clearfix" style="width:100%">
				<h2 class="ico_mug">Panel shortcuts</h2>
				<ul>
					
					
					<li class="first_li"><a href="emailview.php"><img src="img/ftp.jpg" alt="FTP" /><span>Email</span></a></li>
					<!--<li><a href="userview.php"><img src="img/users.jpg" alt="Users" /><span>Users</span></a></li>-->
					<li><a href="domainview.php"><img src="img/comments.jpg" alt="Comments" /><span>Domain</span></a></li>
					<li><a href="expirydomain.php"><img src="img/comments.jpg" alt="Comments" /><span>Expiry Domain</span></a></li>
					
				</ul>
			</div>
</div>
</div>
<?php include('admin_footer.php');?>
