<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Cyber Pirates</title>
		<meta name="description" content="Cyber Pirates is an online treasure hunt competition. Its a challenging and competitive way to gain knowledge" />
		<meta name="keywords" content="Cyber,Pirates,Cyb3r,Pirat3s,online,treasure,hunt,CCS,Helix,Thapar" />
                <meta name="author" content="Ramakrishna"/>
                <link rel="shortcut icon" href="img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/component.css" />
                <link rel="stylesheet" type="text/css" href="../css/content.css" />
                <link rel="stylesheet" type="text/css" href="../css/template.css" />
                <script src="../js/jquery.js"></script>
                <style>
                    p{
                        font-size: 1.5em;
                        margin-left: 18em;
                        background-color: rgba(0,0,0,0.8);
                    }
                </style>
	</head>
        <body style="background-image: url(../img/codex.jpg);color: white;">
            <div class="container">
			<!-- Top Navigation -->
                        <div style="margin-top:-1.6%;" class="codrops-top clearfix">
                            <?php include_once '../php/header.php';?>
                        </div>
                        
                        <h1><span style="font-size: 2em;margin-left: 8.2em">Pirata Codex</span></h1>
        <?php include_once '../php/pirata-codex.php';?>
            <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=260210997519739&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        </body>
</html>
