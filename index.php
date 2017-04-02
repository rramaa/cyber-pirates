<?php
    include_once 'php/connect.php';
    include_once 'php/functions.php';
    if(isset($_SESSION['username']) && isset($_SESSION['userlevel']))
    {
        header("Location:php/common.php");
    }
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['cpassword']))
    {
        $username=  filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $captainname=  filter_input(INPUT_POST,'captainname',FILTER_SANITIZE_SPECIAL_CHARS);
        $membername=  filter_input(INPUT_POST,'membername',FILTER_SANITIZE_SPECIAL_CHARS);
        $email=  filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $password=  filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        $cpassword=  filter_input(INPUT_POST,'cpassword',FILTER_SANITIZE_SPECIAL_CHARS);
        $college=  filter_input(INPUT_POST,'college',FILTER_SANITIZE_SPECIAL_CHARS);
        if($college=="")$college="Not Provided";
        if($username=="" || $cpassword=="" || $password=="" || $email=="" || $captainname=="")
        {
            echo "<script>alert(\"Please fill the required fields\");</script>";
        }
        else {
            if($password==$cpassword)
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $query="INSERT INTO `user_info` (`userid`,`teamname`,`captainname`,`membername`,`email`,`password`,`college`,`code`) VALUES (NULL,:teamname,:captainname,:membername,:email,:password,:college,:code)";
                    try{
                        $stmt=$conn->prepare($query);
                        $code=  random_code(5);
                        $stmt->execute(array(':teamname'=>$username,':captainname'=>$captainname,':membername'=>$membername,':email'=>$email,':password'=>$password,':college'=>$college,':code'=>$code));
                    } catch (PDOException $e) {
                         $error=$e->getCode();
                         if($error==23000)
                         echo "<script>alert(\"Please don't try to imitate another pirate!\");</script>";
                    }
                    $query="SELECT `userid` FROM `user_info` WHERE `teamname`=:teamname";
                    try{
                        $stmt=$conn->prepare($query);
                        $stmt->execute(array(':teamname'=>$username));
                        $result=$stmt->fetchAll();
                    } catch (PDOException $e) {
                        echo "ERROR:".$e->getMessage();
                         
                    }
                    if(count($result) && !isset($error))
                    {
                        $query="INSERT INTO `user_level` (`userid`,`teamname`) VALUES (:userid,:teamname)";
                        try{
                            $stmt=$conn->prepare($query);
                            $stmt->execute(array(':userid'=>$result[0]['userid'],':teamname'=>$username));
                        } catch (PDOException $e) {
                             //echo "ERROR:".$e->getMessage();
                        }
                        echo "<script>alert(\"You have successfully signed up\");</script>";
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$headers .= "From: captain@cyb3rpirat3s.edu";
                        $message="<html><body>Dear $username,<br><a href='cyb3rpirat3s.in/verify/?code=$code'>Click Here to verify your email.</a></body></html>";
                        mail($email, "You have successfully signed up for Cyb3e Pirat3s", $message,$headers);
                }
                }
                else
                {
                    echo "<script>alert(\"Please enter a valid email\");</script>";
                }
            }
            else{
                echo "<script>alert(\"Passwords do not match\");</script>";
            }
        }
    }
    else if(isset($_POST['username']) && isset($_POST['password']))
    {
        $username=  filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $password=  filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        try{
            $query="SELECT `userid` FROM `user_info` WHERE `teamname`=:username AND `password`=:password LIMIT 1";
            $stmt=$conn->prepare($query);
            $stmt->execute(array(':username'=>$username,':password'=>$password));
            $result=$stmt->fetchAll();
        } catch (PDOException $e) {
            echo "ERROR:".$e->getMessage();
        }
        if(count($result))
        {
            foreach ($result as $row)
            {
                //$_SESSION['username']=$username;
                $userid=$row['userid'];
                $query_level="SELECT `level`,`verify` FROM `user_level` WHERE `userid`=:userid";
                $stmt_level=$conn->prepare($query_level);
                $stmt_level->execute(array(':userid'=>$userid));
                $result_level=$stmt_level->fetchAll();
                if($result_level[0]['verify']==1)
                {
                    $level=$result_level[0]['level'];
                    $_SESSION['username']=$username;
                    $_SESSION['userlevel']=$level;
                    $_SESSION['userid']=$userid;
                    header("Location:php/common.php");
                }
                else
                {
                    echo "<script>alert(\"Please confirm your email\");</script>";
                }
            }
        }
        else
        {
        	echo "<script>alert(\"Username/Password is invalid\");</script>";
        }
    }
?>
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
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="css/content.css" />
		<script src="js/modernizr.custom.js"></script>
                <script src="js/jquery.js"></script>
	</head>
	<body >
            <div id='background-index'>
            </div>
		<div class="container">
			<!-- Top Navigation -->
			<div class="codrops-top clearfix">
                            <?php include_once 'php/header.php';?>
                            
			</div>
			<header  class="codrops-header">
				<h1>Cyber Pirates</h1>
				<p>The Hunt Begins</p>
			</header>
			<section>
				<div class="mockup-content">
					<div class="morph-button morph-button-modal morph-button-modal-2 morph-button-fixed">
						<button style="background-color: rgba(150,150,150,0.3);font-weight: bold;" type="button">Login</button>
						<div class="morph-content">
							<div>
								<div class="content-style-form content-style-form-1">
									<span class="icon icon-close">Close the dialog</span>
                                                                        <h2 style="color: rgb(111, 111, 0);">Login</h2>
                                                                        <form method="POST" id="login">
                                                                            <p><label>Username</label><input required type="text" name="username" /></p>
                                                                            <p><label>Password</label><input required type="password" name="password" /></p>
                                                                                <p><button name="login" id="login-button" value="login">Login</button></p>
                                                                        </form>
                                                                        
                                                                        <!--signup form-->
                                                                        
                                                                        
                                                                        
                                                                        <script type="text/javascript">
                                                                            $("#login-button").click(function(){
                                                                                $("#login").submit();
                                                                            });
                                                                        </script>
								</div>
							</div>
						</div>
					</div><!-- morph-button -->
					<strong class="joiner">or</strong>
                                        <div class="morph-button morph-button-modal morph-button-modal-3 morph-button-fixed">
                                            <button style="background-color: rgba(150,150,150,0.3);font-weight: bold;" type="button">Signup</button>
						<div style="overflow-y: scroll" class="morph-content">
                                                    <div>
								<div class="content-style-form content-style-form-2">
									<span class="icon icon-close">Close the dialog</span>
                                                                        <h2 style="color: rgb(111, 111, 0);">Sign Up</h2>
                                                                        <form method="POST" id="signup">
										<p><label>Team Name</label><input required name="username" type="text" /></p>
                                                                                <p><label>Captain Name</label><input required name="captainname" type="text" /></p>
                                                                                <p><label>Member name</label><input name="membername" type="text" /></p>
                                                                                <p><label>Email</label><input required name="email" type="text" /></p>
                                                                                <p><label>Password</label><input required name="password" type="password" /></p>
                                                                                <p><label>Repeat Password</label><input required name="cpassword" type="password" /></p>
                                                                                <p><label>College</label><input name="college" type="text" /></p>
                                                                                <p><button name="signup" id="signup-button">Sign Up</button></p>
									</form>
                                                                        <script>
                                                                            $("#signup-button").click(function(){
                                                                                $("#signup").submit();
                                                                            });
                                                                        </script>
								</div>
							</div>
						</div>
					</div><!-- morph-button -->
				</div><!-- /form-mockup -->
                                <div id="pirata-codex" class="morph-button morph-button-overlay morph-button-fixed">
					<button style="background-color: #9090ff;" type="button">Pirata Codex</button>
					<div style="background-color: #9090ff;overflow-y: scroll" class="morph-content">
						<div>
							<div class="content-style-overlay">
								<span class="icon icon-close">Close the overlay</span>
								<h2>Pirata Codex</h2>
                                                                <?php include_once 'php/pirata-codex.php';?>
							</div>
						</div>
					</div>
				</div>
                                <div id="leaderboard-main" class="morph-button morph-button-overlay morph-button-fixed">
					<button style="background-color: #9090ff;" type="button">Leaderboard</button>
					<div style="background-color: #9090ff; overflow-y: scroll" class="morph-content">
						<div>
							<div class="content-style-overlay">
								<span class="icon icon-close">Close the overlay</span>
								<h1 style='font-size:2.5em;margin-top: -2%'>Leaderboard-Top 10</h1>
                                                                <table border='1' id='leaderboard-top10'>
                                                                    <thead>
                                                                        <tr><th>Rank</th><th>Team Name</th><th>Level</th><th>College/Institution</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $query_level="SELECT * FROM `user_level` ORDER BY `level` DESC, `time` ASC LIMIT 10";
                                                                        try{
                                                                            $stmt_level=$conn->prepare($query_level);
                                                                            $stmt_level->execute(array());
                                                                            $result=$stmt_level->fetchAll();
                                                                        } catch (PDOException $e) {
                                                                            echo "ERROR:".$e->getMessage();
                                                                        }
                                                                        $rank=1;
                                                                        if(count($result))
                                                                        {
                                                                            foreach ($result as $row)
                                                                            {
                                                                                $query_info="SELECT `college` FROM `user_info` WHERE `teamname`=:teamname";
                                                                                try{
                                                                                    $stmt_info=$conn->prepare($query_info);
                                                                                    $stmt_info->execute(array(':teamname'=>$row['teamname']));
                                                                                    $result_info=$stmt_info->fetchAll();
                                                                                } catch (PDOException $e) {
                                                                                    echo "ERROR:".$e->getMessage();
                                                                                }
                                                                                if(count($result_info))
                                                                                {
                                                                                    echo "<tr><td>$rank</td><td>".$row['teamname']."</td><td>".$row['level']."</td><td>".$result_info[0]['college']."</td></tr>";
                                                                                    $rank++;
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <tr><td colspan="4"><a id="entire-leaderboard" target="_blank" href="leaderboard/">Click Here to view the entire leaderboard</a></td></tr>
                                                                    </tbody>
                                                                </table>
							</div>
						</div>
					</div>
				</div>
			</section>
                        <section class="related" style="margin-top: -6%">
                            <p style="font-family: Electrolize">Contact us at cyb3rpirates@gmail.com</p>
			</section>
		</div><!-- /container -->
		<script src="js/classie.js"></script>
		<script src="js/uiMorphingButton_fixed.js"></script>
		<script>
			(function() {
				var docElem = window.document.documentElement, didScroll, scrollPosition;

				// trick to prevent scrolling when opening/closing button
				function noScrollFn() {
					window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
				}

				function noScroll() {
					window.removeEventListener( 'scroll', scrollHandler );
					window.addEventListener( 'scroll', noScrollFn );
				}

				function scrollFn() {
					window.addEventListener( 'scroll', scrollHandler );
				}

				function canScroll() {
					window.removeEventListener( 'scroll', noScrollFn );
					scrollFn();
				}

				function scrollHandler() {
					if( !didScroll ) {
						didScroll = true;
						setTimeout( function() { scrollPage(); }, 60 );
					}
				};

				function scrollPage() {
					scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
					didScroll = false;
				};

				scrollFn();

				[].slice.call( document.querySelectorAll( '.morph-button' ) ).forEach( function( bttn ) {
					new UIMorphingButton( bttn, {
						closeEl : '.icon-close',
						onBeforeOpen : function() {
							// don't allow to scroll
							noScroll();
						},
						onAfterOpen : function() {
							// can scroll again
							canScroll();
						},
						onBeforeClose : function() {
							// don't allow to scroll
							noScroll();
						},
						onAfterClose : function() {
							// can scroll again
							canScroll();
						}
					} );
				} );

				// for demo purposes only
				[].slice.call( document.querySelectorAll( 'form button' ) ).forEach( function( bttn ) { 
					bttn.addEventListener( 'click', function( ev ) { ev.preventDefault(); } );
				} );
			})();
                        
                        
                        
                        
                        
                        
                        
                        
                        (function() {	
				var docElem = window.document.documentElement, didScroll, scrollPosition;

				// trick to prevent scrolling when opening/closing button
				function noScrollFn() {
					window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
				}

				function noScroll() {
					window.removeEventListener( 'scroll', scrollHandler );
					window.addEventListener( 'scroll', noScrollFn );
				}

				function scrollFn() {
					window.addEventListener( 'scroll', scrollHandler );
				}

				function canScroll() {
					window.removeEventListener( 'scroll', noScrollFn );
					scrollFn();
				}

				function scrollHandler() {
					if( !didScroll ) {
						didScroll = true;
						setTimeout( function() { scrollPage(); }, 60 );
					}
				};

				function scrollPage() {
					scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
					didScroll = false;
				};

				scrollFn();
				
				var el = document.querySelector( '.morph-button' );
				
				new UIMorphingButton( el, {
					closeEl : '.icon-close',
					onBeforeOpen : function() {
						// don't allow to scroll
						noScroll();
					},
					onAfterOpen : function() {
						// can scroll again
						canScroll();
						// add class "noscroll" to body
						classie.addClass( document.body, 'noscroll' );
						// add scroll class to main el
						classie.addClass( el, 'scroll' );
					},
					onBeforeClose : function() {
						// remove class "noscroll" to body
						classie.removeClass( document.body, 'noscroll' );
						// remove scroll class from main el
						classie.removeClass( el, 'scroll' );
						// don't allow to scroll
						noScroll();
					},
					onAfterClose : function() {
						// can scroll again
						canScroll();
					}
				} );
			})();
		</script>
                <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=260210997519739&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	</body>
</html>