<?php

function ValidateEmail($email)
	{
	$pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
	return preg_match($pattern, $email);
	}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'form1')
	{
	$mailto = 'pools@privatepools.co.za';
	$mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
	$subject = 'Contact Information';
	$message = 'Values submitted from web site form:';
	$success_url = 'www.listurcell.co.za/Thank_You_List.html';
	$error_url = '';
	$error = '';
	$dbhost = 'localhost';
	$dbuser = 'rmidwdnr_Dewaal';
	$dbpass = '*********';
	$dbname = "rmidwdnr_list01";
	$eol = "\n";
	$boundary = md5(uniqid(time()));
	$header = 'From: ' . $mailfrom . $eol;
	$header.= 'Reply-To: ' . $mailfrom . $eol;
	$header.= 'MIME-Version: 1.0' . $eol;
	$header.= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol;
	$header.= 'X-Mailer: PHP v' . phpversion() . $eol;
	if (!ValidateEmail($mailfrom))
		{
		$error.= "The specified email address is invalid!\n<br />";
		}

	if (!empty($error))
		{
		$errorcode = file_get_contents($error_url);
		$replace = "##error##";
		$errorcode = str_replace($replace, $error, $errorcode);
		echo $errorcode;
		exit;
		}

	$internalfields = array(
		"submit",
		"reset",
		"send",
		"filesize",
		"formid",
		"captcha_code",
		"recaptcha_challenge_field",
		"recaptcha_response_field",
		"g-recaptcha-response"
	);
	$message.= $eol;
	$message.= "IP Address : ";
	$message.= $_SERVER['REMOTE_ADDR'];
	$message.= $eol;
	$logdata = '';
	foreach($_POST as $key => $value)
		{
		if (!in_array(strtolower($key) , $internalfields))
			{
			if (!is_array($value))
				{
				$message.= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
				}
			  else
				{
				$message.= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
				}
			}
		}

	$body = 'This is a multi-part message in MIME format.' . $eol . $eol;
	$body.= '--' . $boundary . $eol;
	$body.= 'Content-Type: text/plain; charset=ISO-8859-1' . $eol;
	$body.= 'Content-Transfer-Encoding: 8bit' . $eol;
	$body.= $eol . stripslashes($message) . $eol;
	if (!empty($_FILES))
		{
		foreach($_FILES as $key => $value)
			{
			if ($_FILES[$key]['error'] == 0)
				{
				$body.= '--' . $boundary . $eol;
				$body.= 'Content-Type: ' . $_FILES[$key]['type'] . '; name=' . $_FILES[$key]['name'] . $eol;
				$body.= 'Content-Transfer-Encoding: base64' . $eol;
				$body.= 'Content-Disposition: attachment; filename=' . $_FILES[$key]['name'] . $eol;
				$body.= $eol . chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))) . $eol;
				}
			}
		}

	$body.= '--' . $boundary . '--' . $eol;
	if ($mailto != '')
		{
		mail($mailto, $subject, $body, $header);
		}

	$search = array(
		"ä",
		"Ä",
		"ö",
		"Ö",
		"ü",
		"Ü",
		"ß",
		"!",
		"§",
		"$",
		"%",
		"&",
		"/",
		"\x00",
		"^",
		"°",
		"\x1a",
		"-",
		"\"",
		" ",
		"\\",
		"\0",
		"\x0B",
		"\t",
		"\n",
		"\r",
		"(",
		")",
		"=",
		"?",
		"`",
		"*",
		"'",
		":",
		";",
		">",
		"<",
		"{",
		"}",
		"[",
		"]",
		"~",
		"²",
		"³",
		"~",
		"µ",
		"@",
		"|",
		"<",
		"+",
		"#",
		".",
		"´",
		"+",
		","
	);
	$replace = array(
		"ae",
		"Ae",
		"oe",
		"Oe",
		"ue",
		"Ue",
		"ss"
	);
	foreach($_POST as $name => $value)
		{
		$name = str_replace($search, $replace, $name);
		$name = strtoupper($name);
		$form_data[$name] = $value;
		if (isset($_POST['add'])) $conn = mysql_connect($dbhost, $dbuser, $dbpass, $dbname);
		if (!$conn)
			{
			die('Could not connect: ' . mysql_error());
			}

		if (!get_magic_quotes_gpc())
			{
			$Cellphone_Number = addslashes($_POST['Cellphone Number']);
			$Business_Name = addslashes($_POST['Business Name']);
			$Catagory = addslashes($_POST['Catagory']);
			$Service = addslashes($_POST['Service']);
			$Website = addslashes($_POST['Website']);
			$Adress = addslashes($_POST['Adress']);
			$City_Town = addslashes($_POST['City/Town']);
			$Province = addslashes($_POST['Province']);
			$Name = addslashes($_POST['Name']);
			$Surname = addslashes($_POST['Surname']);
			$Email = addslashes($_POST['Email']);
			$Designation = addslashes($_POST['Designation']);
			$Landline = addslashes($_POST['Landline']);
			$Fax = addslashes($_POST['Fax']);
			$Comments = addslashes($_POST['Comments']);
			$Date = addslashes($_POST['Date']);
			$Refferal_Code = addslashes($_POST['Refferal Code']);
			}
		  else
			{
			$Cellphone_Number = $_POST['Cellphone Number'];
			$Business_Name = $_POST['Business Name'];
			$Catagory = $_POST['Catagory'];
			$Service = $_POST['Service'];
			$Website = $_POST['Website'];
			$Adress = $_POST['Adress'];
			$City_Town = $_POST['City/Town'];
			$Province = $_POST['Province'];
			$Name = $_POST['Name'];
			$Surname = $_POST['Surname'];
			$Email = $_POST['Email'];
			$Designation = $_POST['Designation'];
			$Landline = $_POST['Landline'];
			$Fax = $_POST['Fax'];
			$Comments = $_POST['Comments'];
			$Date = $_POST['Date'];
			$Refferal_Code = $_POST['Refferal Code'];
			}

		mysql_select_db('rmidwdnr_list01');
		$sql = "INSERT INTO `list01`(`Cellphone Number`, `Business Name`, `Catagory`, `Service`, `Website`, `Adress`, `City/Town`, `Province`, `Name`, `Surname`, `Email`, `Designation`, `Landline`, `Fax`, `Comments`, `Date`, `Refferal Code`)"."VALUES ('Cellphone Number','Business_Name',Catagory,Service,Website,Adress,'City/Town',Province,Name,Surname,Email,Designation,Landline,Fax,Comments,Date,'Refferal Code')";
	{
		$retval = mysql_query( $sql, $conn );

            if(! $retval )
            {
              die('Could not enter data: ' . mysql_error());
            }
        echo "Entered data successfully\n";
        
        mysql_close($conn);

        }
      }
   }

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>List</title>
<meta name="generator" content="WYSIWYG Web Builder 10 Trial Version - http://www.wysiwygwebbuilder.com">
<link href="index2.css" rel="stylesheet">
<link href="List.css" rel="stylesheet">
<script>
function Validatecontact(theForm)
{
   var regexp;
   regexp = /^[-+]?\d*\.?\d*$/;
   if (!regexp.test(theForm.Editbox1.value))
   {
      alert("Please enter only digit characters in the \"Editbox1\" field.");
      theForm.Editbox1.focus();
      return false;
   }
   if (theForm.Editbox1.value == "")
   {
      alert("Please enter a value for the \"Editbox1\" field.");
      theForm.Editbox1.focus();
      return false;
   }
   if (theForm.Editbox2.value == "")
   {
      alert("Please enter a value for the \"Editbox2\" field.");
      theForm.Editbox2.focus();
      return false;
   }
   regexp = /^[A-Za-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ]*$/;
   if (!regexp.test(theForm.Editbox8.value))
   {
      alert("Please enter only letter characters in the \"name\" field.");
      theForm.Editbox8.focus();
      return false;
   }
   if (theForm.Editbox8.value == "")
   {
      alert("Please enter a value for the \"name\" field.");
      theForm.Editbox8.focus();
      return false;
   }
   regexp = /^[A-Za-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ]*$/;
   if (!regexp.test(theForm.Editbox9.value))
   {
      alert("Please enter only letter characters in the \"Editbox9\" field.");
      theForm.Editbox9.focus();
      return false;
   }
   if (theForm.Editbox9.value == "")
   {
      alert("Please enter a value for the \"Editbox9\" field.");
      theForm.Editbox9.focus();
      return false;
   }
   regexp = /^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i;
   if (!regexp.test(theForm.Editbox10.value))
   {
      alert("Wrong E-mail Format");
      theForm.Editbox10.focus();
      return false;
   }
   if (theForm.Editbox10.value == "")
   {
      alert("Wrong E-mail Format");
      theForm.Editbox10.focus();
      return false;
   }
   return true;
}
</script>
</head>
<body>
<a href="http://www.wysiwygwebbuilder.com" target="_blank"><img src="images/builtwithwwb10.png" alt="WYSIWYG Web Builder" style="position:absolute;left:21px;top:952px;border-width:0;z-index:250"></a>
<table style="position:absolute;left:5px;top:5px;width:1248px;height:207px;z-index:33;" id="Table1">
<tr>
<td class="cell0"><span style="color:#000000;font-family:Arial;font-size:13px;line-height:16px;"> </span></td>
</tr>
</table>
<table style="position:absolute;left:5px;top:212px;width:294px;height:1190px;z-index:34;" id="Table2">
<tr>
<td class="cell0"><span style="color:#000000;font-family:Arial;font-size:13px;line-height:16px;"> </span></td>
</tr>
</table>
<table style="position:absolute;left:951px;top:211px;width:302px;height:1191px;z-index:35;" id="Table3">
<tr>
<td class="cell0"><span style="color:#000000;font-family:Arial;font-size:13px;line-height:16px;"> </span></td>
</tr>
</table>
<table style="position:absolute;left:298px;top:1202px;width:653px;height:200px;z-index:36;" id="Table4">
<tr>
<td class="cell0"><span style="color:#000000;font-family:Arial;font-size:13px;line-height:16px;"> </span></td>
</tr>
</table>
<div id="wb_Image1" style="position:absolute;left:13px;top:15px;width:275px;height:184px;z-index:37;">
<img src="images/foon1-7c88932e.png" id="Image1" alt=""></div>
<div id="wb_Text1" style="position:absolute;left:299px;top:27px;width:466px;height:73px;text-align:center;z-index:38;">
<span style="color:#FFFFFF;font-family:'Times New Roman';font-size:64px;">Listurcell</span></div>
<div id="wb_Text2" style="position:absolute;left:298px;top:171px;width:93px;height:16px;z-index:39;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:13px;">List</span></div>
<div id="wb_Image2" style="position:absolute;left:737px;top:141px;width:214px;height:58px;z-index:40;">
<a href="https://www.facebook.com/Listurcell"><img src="images/Facebook.png" id="Image2" alt=""></a></div>
<div id="wb_Image3" style="position:absolute;left:821px;top:27px;width:130px;height:44px;z-index:41;">
<a href="http://www.google.co.za"><img src="images/google.png" id="Image3" alt=""></a></div>
<div id="wb_Image4" style="position:absolute;left:765px;top:81px;width:187px;height:46px;z-index:42;">
<a href="http://www.twitter.com"><img src="images/twitter.jpg" id="Image4" alt=""></a></div>
<div id="wb_Image5" style="position:absolute;left:983px;top:237px;width:241px;height:161px;z-index:43;">
<a href="https://www.cellc.co.za/cellc/home"><img src="images/Cellc%20pic.png" id="Image5" alt=""></a></div>
<div id="wb_Image6" style="position:absolute;left:983px;top:418px;width:241px;height:161px;z-index:44;">
<a href="http://www.vodacom.co.za/"><img src="images/Vodacom.png" id="Image6" alt=""></a></div>
<div id="wb_Image7" style="position:absolute;left:983px;top:601px;width:243px;height:190px;z-index:45;">
<a href="https://www.mtn.co.za/Pages/Home.aspx"><img src="images/mtn.png" id="Image7" alt=""></a></div>
<div id="NavigationBar1" style="position:absolute;left:32px;top:274px;width:236px;height:148px;z-index:46;">
<ul class="navbar">
<li><a href="./index.html"><img alt="" src="images/img0005_over.gif" class="hover"><span><img alt="" src="images/img0005.gif"></span></a></li>
<li><a href="./Search.html"><img alt="" src="images/img0006_over.gif" class="hover"><span><img alt="" src="images/img0006.gif"></span></a></li>
<li><a href="./Contact.php"><img alt="" src="images/img0007_over.gif" class="hover"><span><img alt="" src="images/img0007.gif"></span></a></li>
<li><a href="./Terms.html"><img alt="" src="images/img0008_over.gif" class="hover"><span><img alt="" src="images/img0008.gif"></span></a></li>
</ul>
</div>
<div id="wb_Image8" style="position:absolute;left:40px;top:696px;width:205px;height:175px;z-index:47;">
<a href="http://www.proudlysa.co.za/index/index.html"><img src="images/proudsa.png" id="Image8" alt=""></a></div>
<div id="wb_Image9" style="position:absolute;left:40px;top:460px;width:205px;height:205px;z-index:48;">
<a href="http://www.telkom.co.za/today/"><img src="images/telkom.png" id="Image9" alt=""></a></div>
<div id="wb_Image10" style="position:absolute;left:983px;top:809px;width:243px;height:174px;z-index:49;">
<a href="http://home.8ta.com/my8ta/"><img src="images/8ta.png" id="Image10" alt=""></a></div>
<div id="wb_Image11" style="position:absolute;left:961px;top:15px;width:281px;height:184px;z-index:50;">
<img src="images/foon3-351a1763.png" id="Image11" alt=""></div>
<div id="wb_Text4" style="position:absolute;left:426px;top:100px;width:217px;height:19px;z-index:51;text-align:left;">
<span style="color:#FFFFFF;font-family:'Times New Roman';font-size:16px;">The Online Cellphone Directory</span></div>
<div id="wb_Text5" style="position:absolute;left:314px;top:1225px;width:627px;height:123px;text-align:center;z-index:52;">
<span style="color:#000000;font-family:'Times New Roman';font-size:21px;">We Are The World's<br><br> </span><span style="color:#000000;font-family:'Times New Roman';font-size:27px;"><strong>BIGGEST</strong><br></span><span style="color:#000000;font-family:'Times New Roman';font-size:21px;"><br>Online Cellphone Directory!!</span></div>
<div id="wb_Image12" style="position:absolute;left:983px;top:1000px;width:241px;height:179px;z-index:53;">
<a href="http://www.virginmobile.co.za/"><img src="images/Virgin%20Mobile.png" id="Image12" alt=""></a></div>
<div id="wb_Text6" style="position:absolute;left:355px;top:226px;width:556px;height:21px;z-index:54;text-align:left;">
<span style="color:#000000;font-family:'Times New Roman';font-size:19px;">List your Cellphone Number in the Directory by using the form below.</span></div>
<div id="wb_Form1" style="position:absolute;left:328px;top:294px;width:533px;height:885px;z-index:55;">
<form name="contact" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1" onsubmit="return Validatecontact(this)">
<input type="hidden" name="formid" value="form1">
<div id="wb_Text3" style="position:absolute;left:10px;top:15px;width:115px;height:16px;z-index:0;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Cellphone Number:</span></div>
<input type="text" id="Editbox1" style="position:absolute;left:135px;top:6px;width:198px;height:23px;line-height:23px;z-index:1;" name="Editbox1" value="">
<div id="wb_Text7" style="position:absolute;left:10px;top:45px;width:115px;height:16px;z-index:2;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Business Name:</span></div>
<input type="text" id="Editbox2" style="position:absolute;left:135px;top:45px;width:396px;height:23px;line-height:23px;z-index:3;" name="Editbox2" value="">
<div id="wb_Text8" style="position:absolute;left:10px;top:79px;width:115px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Catagory:</span></div>
<input type="text" id="Editbox3" style="position:absolute;left:135px;top:79px;width:396px;height:23px;line-height:23px;z-index:5;" name="Editbox3" value="">
<div id="wb_Text9" style="position:absolute;left:10px;top:116px;width:115px;height:16px;z-index:6;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Service:</span></div>
<input type="text" id="Editbox4" style="position:absolute;left:135px;top:116px;width:396px;height:23px;line-height:23px;z-index:7;" name="Editbox4" value="">
<div id="wb_Text10" style="position:absolute;left:10px;top:151px;width:115px;height:16px;z-index:8;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Website:</span></div>
<input type="text" id="Editbox5" style="position:absolute;left:135px;top:151px;width:396px;height:23px;line-height:23px;z-index:9;" name="Editbox5" value="">
<div id="wb_Text11" style="position:absolute;left:10px;top:194px;width:115px;height:16px;z-index:10;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Adress:</span></div>
<div id="wb_Text12" style="position:absolute;left:10px;top:298px;width:115px;height:16px;z-index:11;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">City/Town:</span></div>
<input type="text" id="Editbox6" style="position:absolute;left:135px;top:298px;width:396px;height:23px;line-height:23px;z-index:12;" name="Editbox6" value="">
<div id="wb_Text13" style="position:absolute;left:10px;top:332px;width:115px;height:16px;z-index:13;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Province:</span></div>
<input type="text" id="Editbox7" style="position:absolute;left:135px;top:332px;width:396px;height:23px;line-height:23px;z-index:14;" name="Editbox7" value="">
<div id="wb_Text14" style="position:absolute;left:10px;top:419px;width:115px;height:16px;z-index:15;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Name:</span></div>
<input type="text" id="Editbox8" style="position:absolute;left:135px;top:419px;width:396px;height:23px;line-height:23px;z-index:16;" name="name" value="">
<input type="text" id="Editbox9" style="position:absolute;left:135px;top:460px;width:396px;height:23px;line-height:23px;z-index:17;" name="Editbox9" value="">
<div id="wb_Text16" style="position:absolute;left:10px;top:499px;width:115px;height:16px;z-index:18;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Email:</span></div>
<input type="text" id="Editbox10" style="position:absolute;left:135px;top:499px;width:396px;height:23px;line-height:23px;z-index:19;" name="email" value="">
<div id="wb_Text17" style="position:absolute;left:10px;top:536px;width:115px;height:16px;z-index:20;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Designation:</span></div>
<div id="wb_Text18" style="position:absolute;left:10px;top:577px;width:115px;height:16px;z-index:21;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Landline:</span></div>
<div id="wb_Text19" style="position:absolute;left:10px;top:617px;width:115px;height:16px;z-index:22;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Fax:</span></div>
<input type="text" id="Editbox13" style="position:absolute;left:135px;top:617px;width:396px;height:23px;line-height:23px;z-index:23;" name="Editbox13" value="">
<div id="wb_Text22" style="position:absolute;left:117px;top:383px;width:279px;height:19px;text-align:center;z-index:24;">
<span style="color:#000000;font-family:'Times New Roman';font-size:17px;"><strong><u>Contact Person</u></strong></span></div>
<input type="text" id="Editbox12" style="position:absolute;left:135px;top:577px;width:396px;height:23px;line-height:23px;z-index:25;" name="Editbox12" value="">
<input type="text" id="Editbox11" style="position:absolute;left:135px;top:536px;width:396px;height:23px;line-height:23px;z-index:26;" name="Editbox11" value="">
<div id="wb_Text15" style="position:absolute;left:10px;top:460px;width:115px;height:16px;z-index:27;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Surname:</span></div>
<textarea name="TextArea1" id="TextArea1" style="position:absolute;left:135px;top:185px;width:396px;height:98px;z-index:28;" rows="5" cols="63"></textarea>
<input type="submit" id="Button1" name="" value="Send" style="position:absolute;left:135px;top:851px;width:96px;height:25px;z-index:29;">
<input type="text" id="Editbox14" style="position:absolute;left:135px;top:800px;width:226px;height:23px;line-height:23px;z-index:30;" name="Editbox13" value="">
<div id="wb_Text23" style="position:absolute;left:10px;top:809px;width:115px;height:16px;z-index:31;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Refferal Code:</span></div>
</form>
</div>
<div id="wb_Text20" style="position:absolute;left:338px;top:954px;width:115px;height:16px;z-index:56;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Comments:</span></div>
<textarea name="TextArea2" id="TextArea2" style="position:absolute;left:463px;top:943px;width:396px;height:98px;z-index:57;" rows="5" cols="63"></textarea>
<div id="wb_Text21" style="position:absolute;left:463px;top:265px;width:279px;height:19px;text-align:center;z-index:58;">
<span style="color:#000000;font-family:'Times New Roman';font-size:17px;"><strong><u>Business Information</u></strong></span></div>
<input type="text" id="Editbox15" style="position:absolute;left:463px;top:1055px;width:226px;height:23px;line-height:23px;z-index:59;" name="Editbox13" value="">
<div id="wb_Text24" style="position:absolute;left:338px;top:1055px;width:115px;height:16px;z-index:60;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Date:</span></div>
</body>
</html>
