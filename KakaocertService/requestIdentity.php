<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 카카오톡 사용자에게 본인인증 전자서명을 요청합니다.
  * - 
  */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드, (파트너 사이트에서 확인가능)
  $clientCode = '023030000004';

  // 본인인증 요청정보 객체
  $RequestIdentity = new RequestIdentity();

  // 수신자 정보
  // 휴대폰번호,성명,생년월일 또는 Ci(연계정보)값 중 택 일
  $RequestIdentity->receiverHP = $KakaocertService->encrypt('01054437896');
  $RequestIdentity->receiverName = $KakaocertService->encrypt('최상혁');
  $RequestIdentity->receiverBirthday = $KakaocertService->encrypt('19880301');
  // $RequestIdentity->ci = $KakaocertService->encrypt('');
  
  // 인증요청 메시지 제목 - 최대 40자
  $RequestIdentity->reqTitle = '인증요청 메시지 제목란';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $RequestIdentity->expireIn = 1000;
  // 서명 원문 - 최대 2,800자 까지 입력가능
  $RequestIdentity->token = $KakaocertService->encrypt('본인인증요청토큰');


  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $RequestIdentity->appUseYN = false;

  // App to App 방식 이용시, 에러시 호출할 URL
  // $RequestIdentity->returnURL = 'https://kakao.barocert.com';

  try {
    $result = $KakaocertService->requestIdentity($clientCode, $RequestIdentity);
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
                <legend>본인인증 요청</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                <li>앱스킴 (Scheme) : <?php echo $result->scheme ?></li>
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
