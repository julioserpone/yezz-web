<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- If you delete this meta tag, Half Life 3 will never be released. -->
	<meta name="viewport" content="width=device-width" />

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
	
	<link rel="stylesheet" type="text/css" href="stylesheets/email.css" />

</head>

<body bgcolor="#FFFFFF">


	<!-- BODY -->
	<table class="body-wrap">
		<tr>
			<td></td>
			<td class="container" bgcolor="#FFFFFF">

				<div class="content">
					<table>
						<tr>
							<td>
								<h2>INQUIRY</h2>
							</td>
						</tr>
						<tr>
							<td>
								Category:&nbsp;<?php echo $section ?>
							</td>
						</tr>
						<tr>
							<td>
								Subcategory:&nbsp;<?php echo $form ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>CUSTOMER</strong>
							</td>
						</tr>
						<tr>
							<td>
								Name:&nbsp;<?php echo $name ?>
							</td>
						</tr>
						<tr>
							<td>
								Email:&nbsp;<?php echo $email ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>LOCATION</strong>
							</td>
						</tr>
						<tr>
							<td>
								City:&nbsp;<?php echo $city ?>
							</td>
						</tr>
						<tr>
							<td>
								Country:&nbsp;<?php echo $country ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>PRODUCT (Optional)</strong>
							</td>
						</tr>
						<tr>
							<td>
							Model:&nbsp;<?php echo (isset($product)) ? $product : "" ?>
							</td>
						</tr>
						<tr>
							<td>
								IMEI:&nbsp;<?php echo (isset( $imei)) ? $imei :  "" ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>MESSAGE</strong>
							</td>
						</tr>
						<tr>
							<td>
								<p><?php echo $comment ?><p>
							</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td>
								Marketing Region:&nbsp;<?php echo $region ?>
							</td>
						</tr>
						<tr>
							<td>
								Language:&nbsp;<?php echo $language ?>
							</td>
						</tr>
					</table>
				</div><!-- /content -->

			</td>
			<td></td>
		</tr>
	</table><!-- /BODY -->



</body>
</html>