<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Naver Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 네이버톡 이용자에게 본인인증을 요청합니다.
   * https://developers.barocert.com/reference/naver/php/identity/api#RequestIdentity
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023090000021';

  // 본인인증 요청정보 객체
  $NaverIdentity = new NaverIdentity();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $NaverIdentity->receiverHP = $NavercertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $NaverIdentity->receiverName = $NavercertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $NaverIdentity->receiverBirthday = $NavercertService->encrypt('19700101');
  
  // 고객센터 연락처 - 최대 12자
  $NaverIdentity->callCenterNum = '1600-9854';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $NaverIdentity->expireIn = 1000;

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - 푸시(Push) 인증방식
  $NaverIdentity->appUseYN = false;

  // AppToApp 인증방식에서 사용
  // 모바일장비 유형('ANDROID', 'IOS'), 대문자 입력(대소문자 구분)
  // $NaverIdentity->deviceOSType = 'IOS';

  // AppToApp 방식 이용시, 호출할 URL
  // "http", "https"등의 웹프로토콜 사용 불가
  // $NaverIdentity->returnURL = 'navercert://identity';

  try {
    $result = $NavercertService->requestIdentity($clientCode, $NaverIdentity);
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
                <legend>네이버 본인인증 요청</legend>
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
