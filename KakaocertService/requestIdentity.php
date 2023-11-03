<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 카카오톡 이용자에게 본인인증을 요청합니다.
   * https://developers.barocert.com/reference/kakao/php/identity/api#RequestIdentity
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023040000001';

  // 본인인증 요청정보 객체
  $KakaoIdentity = new KakaoIdentity();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $KakaoIdentity->receiverHP = $KakaocertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $KakaoIdentity->receiverName = $KakaocertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $KakaoIdentity->receiverBirthday = $KakaocertService->encrypt('19700101');
  
  // 인증요청 메시지 제목 - 최대 40자
  $KakaoIdentity->reqTitle = '본인인증 요청 메시지 제목';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $KakaoIdentity->expireIn = 1000;
  // 서명 원문 - 최대 2,800자 까지 입력가능
  $KakaoIdentity->token = $KakaocertService->encrypt('본인인증 요청 원문');

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $KakaoIdentity->appUseYN = false;

  // App to App 방식 이용시, 호출할 URL
  // $KakaoIdentity->returnURL = 'https://kakao.barocert.com';

  try {
    $result = $KakaocertService->requestIdentity($clientCode, $KakaoIdentity);
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
                <legend>카카오 본인인증 요청</legend>
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
