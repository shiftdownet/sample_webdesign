

/******************************************************
* sourceArea(�R���X�g���N�^)                          *
*     �e��I�v�V�����ݒ�{���s                        *
*     carry�t���O�ɂ���Ă͐ݒ�݂̂��s�����s���Ȃ�   *
*******************************************************/
var sourceArea = function(carry,className, sourceClassName, lineClassName, syntaxClassName, reservedName, tabPosition){
	this.syntax = new Array("int","#include","return");
	this.setUp(className, sourceClassName, lineClassName, syntaxClassName, reservedName, tabPosition);
	if(carry) this.carryOut();
};

sourceArea.prototype = {
	/**************************************************
	* setUp                                           *
	*     �e��I�v�V�����ݒ�                          *
	**************************************************/
	setUp : function(className, sourceClassName, lineClassName, syntaxClassName, reservedName, tabPosition){
		this.className       = className       ? className       : "sourceArea"; // ���H����N���X��
		this.sourceClassName = sourceClassName ? sourceClassName : "saSource";   // �\�[�X��CSS�N���X��
		this.lineClassName   = lineClassName   ? lineClassName   : "saLine";     // ���C����CSS�N���X��
		this.reservedName    = reservedName    ? reservedName    : "saReserved"; // �\����CSS�N���X��
		this.tabPosition     = tabPosition     ? true            : false;        // �����^�u�̕␳�����邩
		this.syntaxClassName = syntaxClassName ? syntaxClassName : "saSyntax";   // �\����CSS�N���X��
	},

	/**************************************************
	* carryOut                                        *
	*    ���s                                         *
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
	*     num��tab�𕶎���Ƃ��ĕԂ�                *
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
	*     className�Ŏw�肵���N���X���̑������擾���� *
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
	*     �s�ԍ����s��������������ŕԂ�              *
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
	*     �w�肵���N���X�̑����̃\�[�X�����H���ĕԂ�  *
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
	*    �w�肵���������ɂȂ�悤��                   *
	*    �擪���w�肵�ĕ����Ŗ��߂�                   *
	**************************************************/
	getStrFormat : function(num,str,keta){
		var ret = '' + num;
		if(ret.length >= keta) return ret;
		for(var i=ret.length; i<keta; i++) ret = str + ret;
		return ret;
	},
	/**************************************************
	* markUp                                          *
	*    �w�肵��������Ƀ}�[�N���s��                 *
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
	*    �\��ꃊ�X�g��o�^����                       *
	**************************************************/
	setSyntax : function(syntax){
		for(var i=0; i<syntax.length; i++){
			this.syntax[i] = syntax[i];
		}
	}
};








