<? require("config.php"); ?>
<html>
<head>
  <title>RooFToP - PHP Remote FTP Client</title>
<script src="include.js"></script>
</head>
<frameset frameborder="0" border="0" rows="150,*,65" noresize>
  <frame name="navdream" src="connection.php" marginwidth="0" frameborder="0" border="0" target="connection" noresize>
  	<frameset frameborder="0" cols="*,*" scrolling="off" noresiz border="0">
    		<frame name="local" src="local.php" marginwidth="0" marginheight="0" scrolling="auto" target="local" frameborder="0" border="0" noresiz>
    		<frame name="remote" src="remote.php" scrolling="auto" target="remote" frameborder="0" noresiz border="0"> 
  	</frameset>
  <frame name="navdream" src="bottom.php" marginwidth="0" frameborder="0" border="0" target="connection" noresize> 
  <noframes>
    <body>
      <p align="center">Your browser does not support frames</p>
    </body>
  </noframes>
</frameset>
</html>
