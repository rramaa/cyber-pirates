<?php include_once '../php/connect.php'; ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Leaderboard</title>
		<meta name="description" content="leaderboard cyberpirates cyb3rpirat3s rank" />
		<meta name="keywords" content="leaderboard cp cyberpirates cyb3rpirat3s rank" />
		<meta name="author" content="nitrek" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
                <link rel="stylesheet" type="text/css" href="../css/demo.css" />
                <link rel="stylesheet" type="text/css" href="../css/component.css" />
                <link rel="stylesheet" type="text/css" href="../css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/component.css" />
                <link rel="stylesheet" type="text/css" href="../css/content.css" />
                <link rel="stylesheet" type="text/css" href="../css/template.css" />
                <script src="../js/jquery.js"></script>
		<style type="text/css">
		body{
			background: url("back-leaderboard.jpg");
			background-size: cover;
                        background-repeat: no-repeat; 
                        background-attachment: fixed;
                        background-position: center center;

		}
		</style>
		<!--[if IE]>
  		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<!-- Top Navigation -->
                        <div style="margin-top: 0%;" class="codrops-top clearfix">
                            <?php include_once '../php/header.php';?>
                        </div>
                        <header>
                            <h1 style=""><em style="background-color: rgba(0,0,0,0.2); color: white">Leaderboard </em></h1>	
			</header>
                </div>
            
			
			<div class="component">
				<table>
					<thead>
						<tr>
							<th>Teamname</th>
							<th>Level</th>
							<th>Level</th>
                                                        <th>College</th>
							
						</tr>
					</thead>
					<tbody>
					<?php
                                        $query="SELECT `teamname`,`level` FROM user_level ORDER BY `level` DESC, `time` ASC";
                                        try{
                                        $stmt=$conn->prepare($query);
                                        $stmt->execute(array());
                                        $result=$stmt->fetchAll();
                                        }  catch (PDOException $e){
                                            echo "ERROR:".$e->getMessage();
                                        }
                                        if(count($result)){
                                            $rank=1;
                                            foreach ($result as $row)
                                            {
                                                
                                                $teamname=$row['teamname'];
                                                $level=$row['level'];
                                                $query_info="SELECT `college` FROM user_info WHERE `teamname`=:teamname LIMIT 1";
                                                try{
                                                    $stmt_info=$conn->prepare($query_info);
                                                    $stmt_info->execute(array(':teamname'=>$teamname));
                                                    $result_info=$stmt_info->fetchAll();
                                                    }  catch (PDOException $e){
                                                        echo "ERROR:".$e->getMessage();
                                                }
                                                $college=$result_info[0]['college'];
                                                echo "<tr><td class='teamname'>$rank</td><td class='user-email'>$teamname</td><td class='user-phone'>$level</td><td class='user-mobile'>$college</td></tr>";
                                                $rank++;
                                            }
                                        }
						
                                        ?>
						
					</tbody>
				</table>
				
		</div><!-- /container -->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.ba-throttle-debounce.min.js"></script>
		<script src="js/jquery.stickyheader.js"></script>
                <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=260210997519739&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	</body>
</html>