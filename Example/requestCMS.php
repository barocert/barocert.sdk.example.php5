<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 자동이체 출금동의 인증을 요청합니다.
  * - 
  */

  include 'common.php';

  // 이용기관코드, 파트너 사이트에서 확인
  $clientCode = '020040000001';

  // 출금동의 AppToApp 인증 여부
  // true-App To App 방식, false-Talk Message 방식
  $isAppUseYN = false;

  // 자동이체 출금동의 요청정보 객체
  $RequestCMS = new RequestCMS();
  
  $RequestCMS->requestID = 'kakaocert_202303130000000000000000000001';

  // 수신자 정보(휴대폰번호, 성명, 생년월일)와 Ci 값 중 택일
  $RequestCMS->receiverHP = '01087674117';
  $RequestCMS->receiverName = '이승환';
  $RequestCMS->receiverBirthday = '19930112';
  // $RequestCMS->ci = '';

  $RequestCMS->reqTitle = '인증요청 메시지 제공란"';
  $RequestCMS->expireIn = 1000;
  $RequestCMS->requestCorp = '청구 기관명란';
  $RequestCMS->bankName = '출금은행명란';
  $RequestCMS->bankAccountNum = '9-4324-5117-58';
  $RequestCMS->bankAccountName = '예금주명 입력란';
  $RequestCMS->bankAccountBirthday = '19930112';
  $RequestCMS->bankServiceType = 'CMS'; // CMS, FIRM, GIRO

  // App to App 방식 이용시, 에러시 호출할 URL
  // $RequestCMS->returnURL = 'https://kakao.barocert.com';


  try {
    $result = $KakaocertService->requestCMS($clientCode, $RequestCMS, $isAppUseYN);
  }
  catch(BarocertException $pe) {
    $code = $pe->getCode();
    $message = $pe->getMessage();
  }
?>
    <body>
        <div id="content">
            <p class="heading1">Response</p>
            <br/>
            <fieldset class="fieldset1">
                <legend>출금동의 요청</legend>
                <ul>
                <?php
                if ( isset($result) ) {
                ?>
                <li>접수아이디 (receiptId) : <?php echo $result->receiptId ?></li>
                <li>앱스킴 (scheme)[AppToApp 앱스킴 호출용] : <?php echo $result->scheme ?></li>
                <?php
                } else {
                ?>
                <li>Response.code : <?php echo $code ?> </li>
                <li>Response.message : <?php echo $message ?></li>
                <?php
                }
                ?>
                </ul>
            </fieldset>
        </div>
    </body>
</html>
