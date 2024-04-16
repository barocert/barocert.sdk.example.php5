<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php

  /*
   * 패스 이용자에게 자동이체 출금동의를 요청합니다.
   * https://developers.barocert.com/reference/pass/php/cms/api#RequestCMS
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023070000014';

  // 출금동의 요청 정보 객체
  $PassCMS = new PassCMS();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $PassCMS->receiverHP = $PasscertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $PassCMS->receiverName = $PasscertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $PassCMS->receiverBirthday = $PasscertService->encrypt('19700101');

  // 요청 메시지 제목 - 최대 40자
  $PassCMS->reqTitle = '출금동의 요청 메시지 제목';
  // 요청 메시지 - 최대 500자
  $PassCMS->reqMessage = $PasscertService->encrypt('출금동의 요청 메시지');
  // 고객센터 연락처 - 최대 12자
  $PassCMS->callCenterNum = '1600-9854';
  // 요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $PassCMS->expireIn = 1000;
  // 사용자 동의 필요 여부
  $PassCMS->userAgreementYN = true;
  // 사용자 정보 포함 여부
  $PassCMS->receiverInfoYN = true;

  // 출금은행명 - 최대 100자
  $PassCMS->bankName = $PasscertService->encrypt('국민은행');
  // 출금계좌번호 - 최대 31자
  $PassCMS->bankAccountNum = $PasscertService->encrypt('9-****-5117-58');
  // 출금계좌 예금주명 - 최대 100자
  $PassCMS->bankAccountName = $PasscertService->encrypt('홍길동');
  // 출금유형
  // CMS - 출금동의, OPEN_BANK - 오픈뱅킹
  $PassCMS->bankServiceType = $PasscertService->encrypt('CMS'); 
  // 출금액
  $PassCMS->bankWithdraw = $PasscertService->encrypt('1,000,000원'); 

  // AppToApp 요청 여부
  // true - AppToApp 인증방식, false - 푸시(Push) 인증방식
  $PassCMS->appUseYN = false; 
  // ApptoApp 인증방식에서 사용
  // 통신사 유형('SKT', 'KT', 'LGU'), 대문자 입력(대소문자 구분)
  // $PassCMS->telcoType = 'SKT';
  // ApptoApp 인증방식에서 사용
  // 모바일장비 유형('ANDROID', 'IOS'), 대문자 입력(대소문자 구분)
  // $PassCMS->deviceOSType = 'IOS';

  try {
    $result = $PasscertService->requestCMS($clientCode, $PassCMS);
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
                <legend>패스 출금동의 요청</legend>
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
