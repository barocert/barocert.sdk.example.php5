<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Naver Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 네이버 이용자에게 자동이체 출금동의를 요청합니다.
   * https://developers.barocert.com/reference/naver/php/cms/api#RequestCMS
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023090000021';

  // 본인인증 요청정보 객체
  $NaverCMS = new NaverCMS();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $NaverCMS->receiverHP = $NavercertService->encrypt('01067668440');
  // 수신자 성명 - 80자
  $NaverCMS->receiverName = $NavercertService->encrypt('정우석');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $NaverCMS->receiverBirthday = $NavercertService->encrypt('19900911');
  
  // 인증요청 메시지 제목
  $NaverCMS->reqTitle = "출금동의 요청 메시지 제목";
  // 인증요청 메시지
  $NaverCMS->reqMessage = $NavercertService->encrypt("출금동의 요청 메시지");
  // 고객센터 연락처 - 최대 12자
  $NaverCMS->callCenterNum = '1600-9854';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $NaverCMS->expireIn = 1000;

  // 청구기관명
  $NaverCMS->requestCorp = $NavercertService->encrypt("청구기관");
  // 출금은행명
  $NaverCMS->bankName = $NavercertService->encrypt("출금은행");
  // 출금계좌번호
  $NaverCMS->bankAccountNum = $NavercertService->encrypt("123-456-7890");
  // 출금계좌 예금주명
  $NaverCMS->bankAccountName = $NavercertService->encrypt("홍길동");
  // 출금계좌 예금주 생년월일
  $NaverCMS->bankAccountBirthday = $NavercertService->encrypt("19700101");

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $NaverCMS->appUseYN = false;

  // AppToApp 인증방식에서 사용
  // 모바일장비 유형('ANDROID', 'IOS'), 대문자 입력(대소문자 구분)
  // $NaverCMS->deviceOSType = 'IOS';

  // AppToApp 방식 이용시, 호출할 URL
  // "http", "https"등의 웹프로토콜 사용 불가
  // $NaverCMS->returnURL = 'navercert://cms';

  try {
    $result = $NavercertService->requestCMS($clientCode, $NaverCMS);
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
                <legend>네이버 출금동의 요청</legend>
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
