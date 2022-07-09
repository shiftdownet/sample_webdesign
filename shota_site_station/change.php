<?php

	$script = split("\n",$_POST[script]);
	
print <<< EOM



<html>
	<head>
		<title>script</title>
	</head>
	<body style="background-color:$_POST[back]; color:$_POST[normal]">
<!-- source start -->
<pre>\n
EOM;
			$var0 = "(".
				"tukuado words".
				"|endtext".
				"|msg".
				"|_msg".
				"|text".
				"|_text".
				"|startAnim".
				"|stopAnim".
				"|restartAnim".
				"|clearAnim".
				"|addAnimMove".
				"|addAnimZoom".
				"|addAnimLocate".
				"|addAnimRotateToLoop".
				"|addAnimRotateTo".
				"|addAnimRotateLoop".
				"|addAnimRotate".
				"|addAnimCruise".
				"|addAnimAlpha".
				"|step".
				"|wait".
				"|weight".
				"|clear".
				"|shake".
				"|save".
				"|loadval".
				"|loads".
				"|load".
				"|readyLoad".
				"|startLoad".
				"|paint".
				"|erase".
				"|wipe".
				"|locateCenter".
				"|locate".
				"|move".
				"|zoom".
				"|fit".
				"|size".
				"|rotate".
				"|alpha".
				"|music".
				"|stopm".
				"|sound".
				"|menu".
				"|endmenu".
				"|mpos".
				"|mrow".
				"|getMenuIx".
				"|clickmap".
				"|endclickmap".
				"|goto".
				"|if".
				"|endif".
				"|else".
				"|for".
				"|endfor".
				"|gosub".
				"|return".
				"|set".
				"|makeArrayR".
				"|readArrayR".
				"|makeArray".
				"|readArray".
				"|makeReadArray".
				"|rand".
				"|keydown".
				"|key".
				"|mouse".
				"|endsave".
				"|endloadval".
				"|input".
				"|hit".
				"|region".
				"|group".
				"|fadeout".
				"|fadein".
				"|rate".
				"|backColor".
				"|then".
				"|to".
				"|end".
			")";
			foreach ($script as $line){
				preg_match('/;.+$/',$line,$matches);
				$line=preg_replace("/;.+$/", "#comment",$line);
				$line=preg_replace('/(^| |-)(\d+)/',"<font color='$_POST[number]'>$1$2</font>",$line);
				$line=preg_replace('/\$(.*?)\$/',"<font color='$_POST[value]'>\$$1\$</font>",$line);
				$line=preg_replace("/(^$var0| $var0|\t$var0)\b/","<font color='$_POST[word]'>$1</font>",$line);
				$line=preg_replace("/(\*\w+)/","<font color='$_POST[label]'>$1</font>",$line);
				$line=preg_replace("/\"(.*?)\"/","<font color='$_POST[string]'>\"$1\"</font>",$line);
				$line=preg_replace("/#comment/", "<font color='$_POST[comment]'>$matches[0]</font>",$line);

				print $line;
			}

print <<< EOM
\n</pre>
<!-- source end -->
	</body>
</html>
EOM;

?>

