<?php
// －－－－－－－－－－－－－－－－－－－－－－－－
// 問い合わせメールフォーム Ver 1.00
// Copyright (c) pocket-server.com All rights reserved.
// http://www.pocket-server.com/
// －－－－－－－－－－－－－－－－－－－－－－－－

// ----------------
// 基本設定
// ----------------

// ------------- 基本設定ここから -------------

// 送信先メールアドレス
// 問い合わせがあるとこのアドレス宛てにメールが届きます。
// 2箇所まで設定できます。  2箇所目が不要な場合は 空白 '' を設定しておいてください。
$adminMail1='k11096kk@yahoo.co.jp';
$adminMail2='';

// メールの件名
// 問い合わせがあった際に届くメールのタイトル（件名）
$subject='ウェブサイトへの問合せ';

// 送信後の画面に表示されるメッセージ
$endmes=<<<END
<p>お問い合わせ内容を送信しました。</p>
END;

// 戻り先アドレス
// メールを送り終わった後 [戻る]  ボタンをクリックして戻る際の戻り先アドレスです。
// URLを指定できます。 (例) $homeUrl='http://www.xxxx.com/';
$homeUrl='http://shota.site-station.net/tukuado/index.html';

// フォーム中に存在する入力要素
// HTMLの内容に合わせて 入力要素の名前と入力が必須かどうかを指定します。
// HTMLの内容を変更していない場合は設定を変える必要はありません。
// 入力が必須の要素を設定したい場合は、該当要素の array の最後の項目に 1 を記入します。 必須でない場合は 0 を記入します。
$org=array();
$org['namae']=array('お名前',1);
$org['renrakusaki']=array('連絡先メールアドレス',1);
$org['body']=array('お問い合わせ内容',1);

// メールアドレスチェックの有無
// メールアドレスが正しい記述で書かれているかチェックを行う場合は 1   行わない場合は 0 を記入します。
$flg_chkemail = 1;

// メールアドレス入力要素の指定
// HTMLフォームの中で、メールアドレスが記入される要素の名前を記入してください。
// メールアドレスチェックが有効な場合、ここに指定された入力要素に対してチェックを行います。
$mailform = 'renrakusaki';

// 送信者表示名要素の指定
// HTMLフォームの中で、受け取るメールの送信者名として採用したい要素の名前を記入してください。
$fromname = 'namae';

// 使用する日本語文字コード 通常は改変不要
$charset='shift_jis';
// ------------- 基本設定ここまで -------------

// ----------------
// メイン処理
// ----------------

$form=array();

// データの受け取り
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$array = $_GET;
}else{
	$array = $_POST;
}

foreach($array as $key => $value){
	if(isset($org["$key"])){
		$value = trim($value);
		if($org["$key"][1]==1 && $value==''){
			error($org["$key"][0]."が入力されていません。");
		}
		// メアドの正当性チェック
		if($flg_chkemail > 0 && $key == $mailform){
			$value=mb_convert_kana($value,'as','sjis-win'); // 全角英数文字を半角に変換
			if(check_email($value)){ error($org["$key"][0]."が正しくありません。正しいアドレスを入力してください。"); }
		}
		$form[$key] = $value;
	}
}

// 問い合わせメール本文を作成する
$body='';
// 入力フォームの内容を本文に列挙
foreach($form as $key => $value){ $body.=$org[$key][0]."：\n".$value."\n\n"; }
$body.="----------------\n";


// 送信者のアクセス元情報
$agent = getenv("HTTP_USER_AGENT");
$host = getenv("REMOTE_HOST");
$addr = getenv("REMOTE_ADDR");
if($host == '' || $host == $addr){	$host = @gethostbyaddr($addr);	}
$date = gmdate("Y/m/d H:i:s (D)",time()+9*60*60);

$body.=<<<EOM
投稿時間：$date
登録者のIPアドレス：$addr
登録者のホスト名：$host
登録者のブラウザ：$agent
EOM;

// メール送信
sendmail($adminMail1,$form[$mailform],$form[$fromname],$subject,$body);
if($adminMail2){
	sendmail($adminMail2,$form[$mailform],$form[$fromname],$subject,$body);
}

// 送信完了後の画面を表示する。

echo <<<EOM
<html><head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=$charset">
<title>送信完了</title>
</head>
<body>
<H3>送信完了</H3>
{$endmes}
<hr size=1>
<a href="$homeUrl">戻る</a>
</body></html>
EOM;
exit();




// ---------------
// メール送信関数
// ---------------
function sendmail($to,$from,$fromname,$subject,$body){
global $charset;

// To名の生成
if(strpos($to,',')!==FALSE){
	$totext=$to;
}else{
	$totext='=?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($toname,'JIS',"$charset")).'?= <'.$to.'>';
}

// From名の生成
if($from){
	if($fromname == '' ){
		$fromtext="From: $from";
	}else{
		$fromtext='From: =?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($fromname,'JIS',"$charset")).'?= <'.$from.'>';
	}
}

// 件名をエンコード
if($subject){ $subject='=?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($subject,'JIS',"$charset")).'?='; }

//本文をJISにコンバート。改行コードも変換
$body=trim(str_replace("\r\n","\n",mb_convert_encoding($body,"JIS","$charset"))); 

//追加ヘッダ生成
$reheader="{$fromtext}";
$reheader.="\nContent-Type: text/plain;charset=iso-2022-jp";
$reheader=trim($reheader);

// メール送信
mail($totext,$subject,$body,$reheader);
}

// ---------------
// エラー処理
// ---------------
function error($msg){
global $charset;

echo <<<EOM
<html><head>
<meta http-equiv="Content-Language" content="ja">
<meta http-equiv="Content-Type" content="text/html; charset=$charset">
<title>エラー</title>
</head>
<body>
<H3>エラー</H3>
<p>$msg</p>
<hr size=1>
<a href="javascript:history.back();">戻る</a>
</body></html>
EOM;
exit();
}


// ---------------
// メールアドレスの正当性チェック
// ---------------
// 戻り値：正しいアドレス:0     正しくないアドレス:1
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
