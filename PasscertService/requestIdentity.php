<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php

  /*
   * 패스 이용자에게 본인인증을 요청합니다.
   * https://developers.barocert.com/reference/pass/php/identity/api#RequestIdentity
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023070000014';

  // 본인인증 요청정보 객체
  $PassIdentity = new PassIdentity();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $PassIdentity->receiverHP = $PasscertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $PassIdentity->receiverName = $PasscertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $PassIdentity->receiverBirthday = $PasscertService->encrypt('19700101');
  
  // 요청 메시지 제목 - 최대 40자
  $PassIdentity->reqTitle = '본인인증 요청 메시지 제목';
  // 요청 메시지 - 최대 500자
  $PassIdentity->reqMessage = $PasscertService->encrypt('본인인증 요청 메시지');
  // 고객센터 연락처 - 최대 12자
  $PassIdentity->callCenterNum = '1600-9854';
  // 요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $PassIdentity->expireIn = 1000;
  // 서명 원문 - 최대 2,800자 까지 입력가능
  $PassIdentity->token = $PasscertService->encrypt('본인인증 요청 원문');

  // 사용자 동의 필요 여부
  $PassIdentity->userAgreementYN = true;
  // 사용자 정보 포함 여부
  $PassIdentity->receiverInfoYN = true;

  // AppToApp 요청 여부
  // true - AppToApp 인증방식, false - 푸시(Push) 인증방식
  $PassIdentity->appUseYN = false;
  // ApptoApp 인증방식에서 사용
  // 통신사 유형('SKT', 'KT', 'LGU'), 대문자 입력(대소문자 구분)
  // $PassIdentity->telcoType = 'SKT';
  // ApptoApp 인증방식에서 사용
  // 모바일장비 유형('ANDROID', 'IOS'), 대문자 입력(대소문자 구분)
  // $PassIdentity->deviceOSType = 'IOS';

  try {
    $result = $PasscertService->requestIdentity($clientCode, $PassIdentity);
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
                <legend>패스 본인인증 요청</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                  <li>접수아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                  <li>앱스킴 (Scheme) : <?php echo $result->scheme ?></li>
                  <li>앱다운로드URL (marketUrl) : <?php echo $result->marketUrl ?></li>
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
