<?php
	script("script");
	function script($file){
		$file =$file.".txt";
		if(!file_exists($file)){
			print "<b><font color='red'>Error:ファイルがありません。</font></b><BR>";
		}else{

			$fp = fopen($file,"r");
			$cnt0 = 1;
print <<< EOM
<!-- ------------------------------------------------------------------------------- -->
					<div class="script">
						<div class="spt_menu">
							<script type="text/javascript" />
								var ary = new Array("","","","","");
								ary[get] = " class=\"spt_selected\" ";
								document.write("<li><a onClick=\"$.cookie('cssmode',0);location.replace(location.pathname);\" "+ary[0]+">サクラエディタ</a></li>");
								document.write("<li><a onClick=\"$.cookie('cssmode',1);location.replace(location.pathname);\" "+ary[1]+">PHPエディタ</a></li>");
								document.write("<li><a onClick=\"$.cookie('cssmode',2);location.replace(location.pathname);\" "+ary[2]+">HSPスクリプトエディタ</a></li>");
								document.write("<li><a onClick=\"$.cookie('cssmode',3);location.replace(location.pathname);\" "+ary[3]+">メモ帳</a></li>");
								document.write("<li><a onClick=\"$.cookie('cssmode',4);location.replace(location.pathname);\" "+ary[4]+">ノンスタイル</a></li>");
							</script>
						</div>
						<div class="spt_line">
<!-- line start -->
<pre>\n
EOM;
			while ($line = fgets($fp)) {
				print $cnt0."\n";
				$cnt0++;
			}
			rewind($fp);
print <<< EOM
</pre>
<!-- line end -->
						</div>
						<div class="spt_source">
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
			while ($line = fgets($fp)) {
				preg_match('/;.+$/',$line,$matches);
				$line=preg_replace("/;.+$/", "#comment",$line);
				$line=preg_replace('/( |\-)(\d+)(#|$| )/',"<span class='col_num'>$1$2</span>$3",$line);
				$line=preg_replace('/\$(.*?)\$/',"<span class='col_var'>\$$1\$</span>",$line);
				$line=preg_replace("/(".$var0.")\b/","<span class='col_word'>$1</span>",$line);
				$line=preg_replace("/(\*\w+)/","<span class='col_lbl'>$1</span>",$line);
				$line=preg_replace("/\"(.*?)\"/","<span class='col_str'>\"$1\"</span>",$line);
				$line=preg_replace("/#comment/", "<span class='col_comm'>$matches[0]</span>",$line);
				print $line;
			}
			# あははｈｗｗｗｗｗｗｗｗｗｗｗ
print <<< EOM
\n</pre>
<!-- source end -->
						</div>
					</div>
<!-- ------------------------------------------------------------------------------- -->
EOM;
		}
	}
?>

