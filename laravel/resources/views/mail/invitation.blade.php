<?php
?>
{{$mail_data['name']}}さんへ。
チケットコンポーザーのアカウントが発行出来ましたので御連絡致します。
{{$mail_data['name']}}さんのアカウントは以下の通りです。
ログインアカウント：{{$mail_data['email']}}
パスワード：{{$mail_data['password']}}
URL：{{$mail_data['url']}}
URLにアクセスして、ログインリンクをクリックしてください。
尚、セキュリティの為、パスワードはログイン後に変更してください。