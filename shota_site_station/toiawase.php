<?php
// �|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|
// �₢���킹���[���t�H�[�� Ver 1.00
// Copyright (c) pocket-server.com All rights reserved.
// http://www.pocket-server.com/
// �|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|�|

// ----------------
// ��{�ݒ�
// ----------------

// ------------- ��{�ݒ肱������ -------------

// ���M�惁�[���A�h���X
// �₢���킹������Ƃ��̃A�h���X���ĂɃ��[�����͂��܂��B
// 2�ӏ��܂Őݒ�ł��܂��B  2�ӏ��ڂ��s�v�ȏꍇ�� �� '' ��ݒ肵�Ă����Ă��������B
$adminMail1='k11096kk@yahoo.co.jp';
$adminMail2='';

// ���[���̌���
// �₢���킹���������ۂɓ͂����[���̃^�C�g���i�����j
$subject='�E�F�u�T�C�g�ւ̖⍇��';

// ���M��̉�ʂɕ\������郁�b�Z�[�W
$endmes=<<<END
<p>���₢���킹���e�𑗐M���܂����B</p>
END;

// �߂��A�h���X
// ���[���𑗂�I������� [�߂�]  �{�^�����N���b�N���Ė߂�ۂ̖߂��A�h���X�ł��B
// URL���w��ł��܂��B (��) $homeUrl='http://www.xxxx.com/';
$homeUrl='http://shota.site-station.net/tukuado/index.html';

// �t�H�[�����ɑ��݂�����͗v�f
// HTML�̓��e�ɍ��킹�� ���͗v�f�̖��O�Ɠ��͂��K�{���ǂ������w�肵�܂��B
// HTML�̓��e��ύX���Ă��Ȃ��ꍇ�͐ݒ��ς���K�v�͂���܂���B
// ���͂��K�{�̗v�f��ݒ肵�����ꍇ�́A�Y���v�f�� array �̍Ō�̍��ڂ� 1 ���L�����܂��B �K�{�łȂ��ꍇ�� 0 ���L�����܂��B
$org=array();
$org['namae']=array('�����O',1);
$org['renrakusaki']=array('�A���惁�[���A�h���X',1);
$org['body']=array('���₢���킹���e',1);

// ���[���A�h���X�`�F�b�N�̗L��
// ���[���A�h���X���������L�q�ŏ�����Ă��邩�`�F�b�N���s���ꍇ�� 1   �s��Ȃ��ꍇ�� 0 ���L�����܂��B
$flg_chkemail = 1;

// ���[���A�h���X���͗v�f�̎w��
// HTML�t�H�[���̒��ŁA���[���A�h���X���L�������v�f�̖��O���L�����Ă��������B
// ���[���A�h���X�`�F�b�N���L���ȏꍇ�A�����Ɏw�肳�ꂽ���͗v�f�ɑ΂��ă`�F�b�N���s���܂��B
$mailform = 'renrakusaki';

// ���M�ҕ\�����v�f�̎w��
// HTML�t�H�[���̒��ŁA�󂯎�郁�[���̑��M�Җ��Ƃ��č̗p�������v�f�̖��O���L�����Ă��������B
$fromname = 'namae';

// �g�p������{�ꕶ���R�[�h �ʏ�͉��ϕs�v
$charset='shift_jis';
// ------------- ��{�ݒ肱���܂� -------------

// ----------------
// ���C������
// ----------------

$form=array();

// �f�[�^�̎󂯎��
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$array = $_GET;
}else{
	$array = $_POST;
}

foreach($array as $key => $value){
	if(isset($org["$key"])){
		$value = trim($value);
		if($org["$key"][1]==1 && $value==''){
			error($org["$key"][0]."�����͂���Ă��܂���B");
		}
		// ���A�h�̐������`�F�b�N
		if($flg_chkemail > 0 && $key == $mailform){
			$value=mb_convert_kana($value,'as','sjis-win'); // �S�p�p�������𔼊p�ɕϊ�
			if(check_email($value)){ error($org["$key"][0]."������������܂���B�������A�h���X����͂��Ă��������B"); }
		}
		$form[$key] = $value;
	}
}

// �₢���킹���[���{�����쐬����
$body='';
// ���̓t�H�[���̓��e��{���ɗ�
foreach($form as $key => $value){ $body.=$org[$key][0]."�F\n".$value."\n\n"; }
$body.="----------------\n";


// ���M�҂̃A�N�Z�X�����
$agent = getenv("HTTP_USER_AGENT");
$host = getenv("REMOTE_HOST");
$addr = getenv("REMOTE_ADDR");
if($host == '' || $host == $addr){	$host = @gethostbyaddr($addr);	}
$date = gmdate("Y/m/d H:i:s (D)",time()+9*60*60);

$body.=<<<EOM
���e���ԁF$date
�o�^�҂�IP�A�h���X�F$addr
�o�^�҂̃z�X�g���F$host
�o�^�҂̃u���E�U�F$agent
EOM;

// ���[�����M
sendmail($adminMail1,$form[$mailform],$form[$fromname],$subject,$body);
if($adminMail2){
	sendmail($adminMail2,$form[$mailform],$form[$fromname],$subject,$body);
}

// ���M������̉�ʂ�\������B

echo <<<EOM
<html><head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=$charset">
<title>���M����</title>
</head>
<body>
<H3>���M����</H3>
{$endmes}
<hr size=1>
<a href="$homeUrl">�߂�</a>
</body></html>
EOM;
exit();




// ---------------
// ���[�����M�֐�
// ---------------
function sendmail($to,$from,$fromname,$subject,$body){
global $charset;

// To���̐���
if(strpos($to,',')!==FALSE){
	$totext=$to;
}else{
	$totext='=?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($toname,'JIS',"$charset")).'?= <'.$to.'>';
}

// From���̐���
if($from){
	if($fromname == '' ){
		$fromtext="From: $from";
	}else{
		$fromtext='From: =?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($fromname,'JIS',"$charset")).'?= <'.$from.'>';
	}
}

// �������G���R�[�h
if($subject){ $subject='=?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($subject,'JIS',"$charset")).'?='; }

//�{����JIS�ɃR���o�[�g�B���s�R�[�h���ϊ�
$body=trim(str_replace("\r\n","\n",mb_convert_encoding($body,"JIS","$charset"))); 

//�ǉ��w�b�_����
$reheader="{$fromtext}";
$reheader.="\nContent-Type: text/plain;charset=iso-2022-jp";
$reheader=trim($reheader);

// ���[�����M
mail($totext,$subject,$body,$reheader);
}

// ---------------
// �G���[����
// ---------------
function error($msg){
global $charset;

echo <<<EOM
<html><head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=$charset">
<title>�G���[</title>
</head>
<body>
<H3>�G���[</H3>
<p>$msg</p>
<hr size=1>
<a href="javascript:history.back();">�߂�</a>
</body></html>
EOM;
exit();
}


// ---------------
// ���[���A�h���X�̐������`�F�b�N
// ---------------
// �߂�l�F�������A�h���X:0     �������Ȃ��A�h���X:1
function check_email($email){
if($email==''){ return 0; }
$tmp=preg_replace('/^["]+/','',$email);
$tmp=str_replace('"@','@',$tmp);
if(preg_match('/^([0-9a-z._-]+)[@][0-9a-z._-]+\.[0-9a-z]{2,}$/i',$tmp) == 0){
	return 1;
}else{
	return 0;
}
}

?>
