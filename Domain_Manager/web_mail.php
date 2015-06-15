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

include ("database/db_conn.php");
include ("functions/function.php");
include_once("functions/encrypt.php");
include("admin_header.php");


if($_GET['emailid']==''){
$s_title="Add Email";
} else {
$s_title="Update Email";
}


if(isset($_GET['start'])) $start=$_GET['start'];

if(isset($_GET['emailid']))
		{
			$emailid = $_GET['emailid'];
			$sql = "select * from email where emailid = '$emailid'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
		}
		

//checks cookies to make sure they are logged in


			
		if(isset($_GET['emailid']))
		{
			$emailid = $_GET['emailid'];
			$sql = "select * from email where emailid = '$emailid'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
		}
		
		if($_POST['Submit']=='Add')
		{
			$newDate = date("Y-m-d", strtotime($_POST['datum1']));
			$_POST['dob']= $newDate;
			
			//$sql=mysql_query("Select * from lookup_master where lookup_name ='email' and id='".$_POST['emaillast']."'");
			//$email_id=mysql_fetch_assoc($sql);
			$_POST['emailadd']=$_POST['emailfirst'];
			$temp=$_POST['emailadd'];
			
			$sql="Select * from email where emailadd='".$temp."'"; 
			$result=mysql_query($sql);
			$valid=mysql_num_rows($result);

		if($valid != 0)
			{
			echo "<html><head>
				<script language='javascript' type='text/javascript'>
				alert('".$temp." is already exits.');
				window.location.href='email.php';
				</script>";
				
			$_SESSION[emailfirst]=$_POST[emailfirst];
			//$_SESSION[emaillast]=$_POST[emaillast];
			$_SESSION[name]=$_POST[name];
			$_SESSION[emailidpassword]=$crypt->encrypt($_POST[emailidpassword]);
			$_SESSION[pincode]=$_POST[pincode];
			$_SESSION[sec_question]=$_POST[sec_question];
			$_SESSION[sec_answer]=$_POST[sec_answer];
			}
		else
		{
			//$sql_ext=mysql_query("Select * from lookup_master where lookup_name ='email' and id='".$_POST['emaillast']."'");
			//$li_nu=mysql_fetch_assoc($sql_ext);
			//$em1=$li_nu['text'];
			$_POST['emailadd']=$_POST[emailfirst];
			$_POST[userid] = $id;
		 	//$result=insert('email',$_POST,$db);
			
			//start  created by deep on 27/3/2012
			$check_count=check_max("email");
			 if($check_count>4)
			{
				 echo "<script>alert('this is demo');</script>";
			}
			else
			{
			  $result=insert('email',$_POST,$db);

			echo "<html><head>
				<script language='javascript' type='text/javascript'>
				alert('Email Profile Added Successfully');
				window.location.href='emailview.php';
				</script>";	
			 }
			//end  created by deep on 27/3/2012
		}
			unset($_POST['Submit']);
	}




		if(isset($_POST['Update']))
		{
			$newDate = date("Y-m-d", strtotime($_POST['datum1']));
			$_POST['dob']=$newDate;
		
			$_POST['userid'] = $id;
			$pass=$crypt->encrypt($_POST['emailidpassword']);
			
			if($user_level=='1')
			{
				$_POST['emailidpassword']=$pass;
			}
			
		//	$sql=mysql_query("Select * from lookup_master where lookup_name ='email' and id='".$_POST['emaillast']."'");
		//	$email_id=mysql_fetch_assoc($sql);
			
			$_POST['emailadd']=$_POST['emailfirst'];
			$temp=$_POST['emailadd'];
			$sql="Select * from email where emailadd='".$temp."' and emailid!='".$_POST['emailid']."'"; 
		
			$result=mysql_query($sql);
			 $valid=mysql_num_rows($result);
		
			if($valid != 0)
			{
				echo "<html>
							<head>
						<script language='javascript' type='text/javascript'>
						alert('".$temp." is already exits.');
						</script>";
			}
			else
			{
				$upd= update('email',$_POST,$_POST[emailid],$db);
			
				$upd1= update('domain_master',$_POST,$_POST[id],$db);
				
				$start=$_POST['start'];
				echo "<html>
					<head>
					<script language='javascript' type='text/javascript'>
					alert('Email Profile Updated Successfully');
					window.location.href='emailview.php?&start=".$start."';
					</script>";		
				unset($_POST['Update']);
			}
			
		}

?>

       <div class="section">
       <form name="frmemail" id= "frmemail" method="post" enctype="multipart/form-data" action="" >
       
       <label style="color:#FF0000;margin-left:800px;">* All Fields are Mandatory</label>
       <fieldset><legend><span><b>Email Information</b></span></legend>
       <div id="msgerror" style="color:#FF0000;"></div>
       
            <input type="hidden" name="emailadd" >
            <input type="hidden" name="userid" value ="<?php echo $row[userid] ; ?>">
            <input type="hidden" name="emailid" value ="<?php echo $emailid ; ?>">
            <input type="hidden" name="dob" value ="<?php echo $row[dob] ; ?>">
            <input type="hidden" name="start" value="<?php echo $start;?>" >	
           <!-- <input type="hidden" name="formname" id="formname" value="email">-->
                    
                <label><div style="float:left;width:150px;padding-top:5px;">Email ID</div></label>			
                <div><input style=" width:160px;"  type="text" name="emailfirst" id="emailfirst" value="<?php echo $row['emailfirst']; ?>" />
               </div>
                
                	
              
				<?php //getLookupInfo1($row['emaillast'],'emaillast','email','','searchinbx_txt');?>
                   
                        
        		<label><div style="float:left;width:150px;padding-top:5px;">Name</div>
                <div><input style=" width:160px;"  type="text" name="name" id="name" value="<?php  echo $row['name']; ?>"/></div></label>
		
        
				<label><div style="float:left;width:150px;padding-top:5px;">Password</div>
		 		<div><input style=" width:160px;"  type="password" name="emailidpassword" id="emailidpassword" value="<?php  echo $row['emailidpassword']; ?>"/></div></label>
    
    
				<label><div style="float:left;width:150px;padding-top:5px;">Date of Birth</div></label>
				<div>
 
 <!--CALANDER SCRIPT-->  
               <input style=" width:160px;" type="text" name="datum1" id="datum1" value="<?php  echo $row['dob']; ?>" readonly="readonly" ><a href="#" onClick="setYears(1950, 1995);
               showCalender(this, 'datum1');">
              <img src="calender.png"></a>
			 <table id="calenderTable">
        		<tbody id="calenderTableHead">
          		<tr><td colspan="4" align="center">
	            <select onChange="showCalenderBody(createCalender(document.getElementById('selectYear').value,this.selectedIndex, false));" id="selectMonth">
	              <option value="0">Jan</option>
	              <option value="1">Feb</option>
	              <option value="2">Mar</option>
	              <option value="3">Apr</option>
	              <option value="4">May</option>
	              <option value="5">Jun</option>
	              <option value="6">Jul</option>
	              <option value="7">Aug</option>
	              <option value="8">Sep</option>
	              <option value="9">Oct</option>
	              <option value="10">Nov</option>
	              <option value="11">Dec</option>
	          </select>
                </td>
                <td colspan="2" align="center">
                    <select onChange="showCalenderBody(createCalender(this.value, 
                    document.getElementById('selectMonth').selectedIndex, false));" id="selectYear">
                    </select>
                </td>
                <td align="center">
                    <a href="#" onClick="closeCalender();"><font color="" size="+1">X</font></a>
                </td></tr></tbody>
                <tbody id="calenderTableDays">
                <tr style=""><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td>
                </tr></tbody>
                <tbody id="calender"></tbody>
                </table>

<!--CALANDER SCRIPT-->
			</div>
  			
    
            <label><div style="float:left;width:150px;padding-top:5px;">Pin Code</div>
			<div><input style=" width:160px;"  type="text" name="pincode" id="pincode" value="<?php echo $row['pincode']; ?>" onkeypress="return checkIt(event)"/></div></label>
    		<br/>
	
    
    		<label><div style="float:left;width:150px;padding-top:5px;">Select Your Question</div>
		    <div><select  name="sec_question" value="Select Your Question" id="sec_question" title="Security Question" style=" -moz-border-radius: 4px 4px 4px 4px;background: none repeat scroll 0 0 white;border: 1px solid #DDDDDD;color: #222222;margin: 3px;padding: 5px; width: 170px;">
              <option value="">-Select-</option>
  			  <option value="Which city where you born in ?"<?php if($row['sec_question']=='Which city where you born in ?') { ?> selected="selected" <?php } ?>>Which city where you born in ?</option>
              <option value="What is Your Mothers Middle Name ?"<?php if($row['sec_question']=='What is Your Mothers Middle Name ?') { ?> selected="selected" <?php } ?>>What is Your Mothers Middle Name ?</option>
              <option value="What was Name of Your First Pet ?"<?php if($row['sec_question']=='What was Name of Your First Pet ?') { ?> selected="selected" <?php } ?>>What was Name of Your First Pet ?</option>
              <option value="Who is Your Favourite Author ?"<?php if($row['sec_question']=='Who is Your Favourite Author ?') { ?> selected="selected" <?php } ?>>Who is Your Favourite Author ?</option>
              <option value="What was the Last Name of Your Favourite Teacher ?"<?php if($row['sec_question']=='What was the Last Name of Your Favourite Teacher ?') { ?> selected="selected" <?php } ?>>What was the Last Name of Your Favourite Teacher ?</option>
			  </select></div></label>
              <br/>	
     
    
              <label><div style="float:left;width:150px;padding-top:5px;">Your Answer</div>
              <div><input style=" width:160px;"  type="text" name="sec_answer" id="sec_answer" value="<?php echo $row['sec_answer']; ?>" /></div>
              </label>
	
		
    
              <div style="margin-left:150px;">
              <br/>
              <?php if($emailid!='') { ?>
                 <input type="submit" name="Update" value="Update" id="Submit" onclick="return validemail(this.form)" class="btn_nw"/>
              <?php } else { ?>
                 <input type="submit" name="Submit" value="Add" id="Submit" onclick="return validemail(this.form)" class="btn_nw"/>
              <?php } ?>
				<input type="button" name="Submit2" value="Back" onClick= "backemail();" class="btn_nw"></div></label>

			</fieldset>

	</form>

</div>
</div>
<?php include('admin_footer.php');?>
