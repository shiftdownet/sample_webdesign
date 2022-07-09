

/******************************************************
* sourceArea(コンストラクタ)                          *
*     各種オプション設定＋実行                        *
*     carryフラグによっては設定のみを行い実行しない   *
*******************************************************/
var sourceArea = function(carry,className, sourceClassName, lineClassName, syntaxClassName, reservedName, tabPosition){
	this.syntax = new Array("int","#include","return");
	this.setUp(className, sourceClassName, lineClassName, syntaxClassName, reservedName, tabPosition);
	if(carry) this.carryOut();
};

sourceArea.prototype = {
	/**************************************************
	* setUp                                           *
	*     各種オプション設定                          *
	**************************************************/
	setUp : function(className, sourceClassName, lineClassName, syntaxClassName, reservedName, tabPosition){
		this.className       = className       ? className       : "sourceArea"; // 加工するクラス名
		this.sourceClassName = sourceClassName ? sourceClassName : "saSource";   // ソースのCSSクラス名
		this.lineClassName   = lineClassName   ? lineClassName   : "saLine";     // ラインのCSSクラス名
		this.reservedName    = reservedName    ? reservedName    : "saReserved"; // 予約語のCSSクラス名
		this.tabPosition     = tabPosition     ? true            : false;        // 水平タブの補正をするか
		this.syntaxClassName = syntaxClassName ? syntaxClassName : "saSyntax";   // 予約語のCSSクラス名
	},

	/**************************************************
	* carryOut                                        *
	*    実行                                         *
	**************************************************/
	carryOut : function(){
		var elements = this.getElements();
		var line;
		var source;
		for(var i=0; i<elements.length; i++){
			line   = this.getStrLine(elements[i].innerHTML.split("\r\n").length);
			source = this.getStrSource(elements[i]);
			elements[i].innerHTML = line + source;
		}
	},

	/**************************************************
	* putTab                                          *
	*     num個のtabを文字列として返す                *
	**************************************************/
	putTab : function(num){
		if(num<0 || 20<num) return false;
		var tab = "";
		while(num--){
			tab += "\t";
		}
		return tab;
	},
	/**************************************************
	* getElements                                     *
	*     classNameで指定したクラス名の属性を取得する *
	**************************************************/
	getElements : function(){
		var classElements = new Array();
		var allElements   = document.getElementsByTagName("*");
		for(i = 0, j = 0; i < allElements.length; i++){
			if (allElements[i].className == this.className) {
				classElements[j] = allElements[i];
				j++;
			}
		}
		return classElements;
	},
	/**************************************************
	* getStrLine                                      *
	*     行番号を行数分だけ文字列で返す              *
	**************************************************/
	getStrLine : function(num){
		var str = "";
		str += "<pre class="+this.lineClassName+">";
		//for(var i=1; i<num; i++) str += this.getStrFormat(i," ",5) + "\r\n";
		for(var i=1; i<num-1; i++) str += i + "\r\n";
		str += "</pre>";
		return str;
	},
	/**************************************************
	* getStrSource                                    *
	*     指定したクラスの属性のソースを加工して返す  *
	**************************************************/
	getStrSource : function(element){
		var lines = element.innerHTML.split("\r\n");
		var str = "",line = "";
		str += "<pre class="+this.sourceClassName+">";
		for(var i=1; i<lines.length-1; i++){
			line = "";
			if(this.tabPosition) line += this.putTab(lines[i].split("\t").length - lines[1].split("\t").length) + lines[i].replace(/\t/g,"")+"\r\n";
			else                 line += lines[i]+"\r\n";
			line = line.replace("<","&lt;");
			line = line.replace(">","&gt;");
			line=this.markUp(line, this.syntax, this.syntaxClassName);
			str += line;
		}
		str += "</pre>";
		return str;
	},
	/**************************************************
	* getStrFormat                                    *
	*    指定した文字数になるように                   *
	*    先頭を指定して文字で埋める                   *
	**************************************************/
	getStrFormat : function(num,str,keta){
		var ret = '' + num;
		if(ret.length >= keta) return ret;
		for(var i=ret.length; i<keta; i++) ret = str + ret;
		return ret;
	},
	/**************************************************
	* markUp                                          *
	*    指定した文字列にマークを行う                 *
	**************************************************/
	markUp : function(line,list,className){
		var reg;
		for(var i=0; i<list.length; i++){
			reg = new RegExp("( |\t|^)("+list[i]+")( |\t|\r\n|$)","g");
			line = line.replace(reg,function(class,s1){return ("<span class='"+ class +"'>"+ s1 +"</span>")}(className,"$1$2$3"));
		}
		return line;
	},

	/**************************************************
	* setSyntax                                       *
	*    予約語リストを登録する                       *
	**************************************************/
	setSyntax : function(syntax){
		for(var i=0; i<syntax.length; i++){
			this.syntax[i] = syntax[i];
		}
	}
};








