<?php
    include_once '../php/connect.php';
    if(isset($_SESSION['username']) && isset($_SESSION['userlevel']) && isset($_SESSION['userid']))
    {
        $userlevel=$_SESSION['userlevel'];
        $userid=$_SESSION['userid'];
        $username=$_SESSION['username'];
        if(isset($_GET['url_hint']))
        {
            $gurl=$_GET['url_hint'];
            $query="SELECT `title`,`source`,`url`,`hover`,`answer` FROM `question` WHERE `qnum`=:userlevel LIMIT 1";
            try{
                $stmt=$conn->prepare($query);
                $stmt->execute(array(':userlevel'=>$userlevel));
                $result=$stmt->fetchAll();
            } catch (PDOException $e) {
                echo "ERROR:".$e->getMessage();
            }
                if(count($result))
                {
                    $title=$result[0]['title'];
                    $source=$result[0]['source'];
                    $url=$result[0]['url'];
                    $answer=$result[0]['answer'];
                    $hover=$result[0]['hover'];
                    if($url!=$gurl)
                    {
                        header("Location:../php/common.php");
                    }
                    else {
                        if(isset($_POST['answer']))
                        {
                            $answered=  filter_input(INPUT_POST,"answer",FILTER_SANITIZE_SPECIAL_CHARS);
                            if($answer==$answered)
                            {
                                $userlevel++;
                                $query_ans="UPDATE `user_level` SET `level`=:userlevel WHERE `userid`=:userid";
                                try{
                                    $stmt_ans=$conn->prepare($query_ans);
                                    $stmt_ans->execute(array(':userlevel'=>$userlevel,':userid'=>$userid));
                                }  catch (PDOException $e){
                                    echo "ERROR:".$e->getMessage();
                                }
                                $_SESSION['userlevel']=$userlevel;
                                header("Location:../question/");
                        }   }
                    }
                }
                else{
                    header("Location:../logout/");
                }
        }
        else
        {
            header("Location:../");
        }
    }
    else
    {
        header("Location:../");
    }
?>
<!DOCTYPE html>
<html lang="en" class="no-js demo-7">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?php echo $title; ?></title>
		<meta name="description" content="Cyber Pirates is an online treasure hunt competition. Its a challenging and competitive way to gain knowledge" />
		<meta name="keywords" content="Cyber,Pirates,Cyb3r,Pirat3s,online,treasure,hunt,CCS,Helix,Thapar" />
                <meta name="author" content="Ramakrishna"/>
                <link rel="shortcut icon" href="../img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/content.css" />
                <link rel="stylesheet" type="text/css" href="../css/template.css"/>
                <link rel='stylesheet' href='../css/prettify.css' />
                <script src="../js/jquery.min.js"></script>
                <script src="../js/jquery.js"></script>
                <script src="../js/template.js"></script>
                <script src="../js/prettify.js"></script>
		<script src="../js/modernizr.custom.js"></script>
	</head>
        <!--
Everything that matters begins here!
        
<?php echo $source; ?>
        
        
Everything that matters ends here!
-->
	<body>
            <div id='background'>
            </div>
		<div id="container" class="container">
			<!-- Top Navigation -->
			<div class="codrops-top clearfix">
                           <?php include_once '../php/header.php';?>
			</div>
			<header class="codrops-header">
				<h1><?php echo "Welcome $username";?></h1>
				<p>You are on level <?php echo $userlevel; ?></p>
                                <div id="leaderboard">
                                    <span>Leaderboard</span>
                                    <table border="1">
                                        <thead>
                                            <tr><th>Rank</th><th style="width:100%;">Name</th><th>Level</th></tr>
                                        </thead>
                                        <tbody id='dynamic-leaderboard'>
                                        
                                        </tbody>
                                    </table>
                                </div>
                                <div id="question">
                                    <a target="_blank" href="../php/getImage.php"><img alt="question-image" title="<?php echo $hover; ?>" src="../php/getImage.php"></a>
                                </div>
                                <div id="answer">
                                    <form method="POST">
                                        <p style="padding-bottom: 5px;"><input style="background-color: #000;border: none;color: #fff;opacity: 1;" type="text" placeholder="Answer here!" name="answer" autocomplete="off" id="answer-box"/></p>
                                        <p style="padding-top: 0px;"><button style="background-color: #000;border: none;color: #fff;opacity: 1;" type="submit">Submit</button></p>
                                        <p><a style="color:white;" href="#source-code">View Source</a></p>
                                        <div id="source-code">
                                            
                                            <a href="#" id="x"><img src="../img/x.png" alt="close"></a>
                                        </div>
                                    </form>
                                </div>
                                
			</header>
			<script>
                            function getLeaderboard(){
                                $.get("dynamic-leaderboard.php",{username:"<?php echo $username; ?>"},function(data){
                                    $("#dynamic-leaderboard").html(data);
                                });
                            }
                            getLeaderboard();
                            var myInterval=setInterval(getLeaderboard,5000);
                        </script>
		</div><!-- /container -->
		<div class="morph-button morph-button-sidebar morph-button-fixed">
                    <button style="background-color: rgb(144,144,255);" type="button"><span class="icon icon-cog">Settings Menu</span></button>
			<div style="background-color: rgb(144,144,255);" class="morph-content">
				<div>
					<div class="content-style-sidebar">
						<span class="icon icon-close">Close the overlay</span>
						<h2 style="color: rgb(111,111,0);">MENU</h2>
						<ul>
							<li><a style="color: rgb(111,111,0);font-size: 1.5em;" class="icon icon-embed" target="_blank" href="../pirata-codex/">Pirata Codex</a></li>
							<li><a style="color: rgb(111,111,0);font-size: 1.5em;" class="icon icon-stats-dots" target="_blank" href="../leaderboard/">Leaderboard</a></li>
                                                        <li><a style="color: rgb(111,111,0);font-size: 1.5em;" class="icon icon-home" href="../logout/">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div><!-- morph-button -->
		<script src="../js/classie.js"></script>
		<script src="../js/uiMorphingButton_fixed.js"></script>
		<script>
			(function() {
				var docElem = window.document.documentElement, didScroll, scrollPosition,
					container = document.getElementById( 'container' );

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
						// push main container
						classie.addClass( container, 'pushed' );
					},
					onAfterOpen : function() {
						// can scroll again
						canScroll();
						// add scroll class to main el
						classie.addClass( el, 'scroll' );
					},
					onBeforeClose : function() {
						// remove scroll class from main el
						classie.removeClass( el, 'scroll' );
						// don't allow to scroll
						noScroll();
						// push back main container
						classie.removeClass( container, 'pushed' );
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