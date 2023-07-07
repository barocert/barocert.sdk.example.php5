<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 카카오톡 사용자에게 출금동의 전자서명을 요청합니다.
   * https://developers.barocert.com/reference/kakao/java/cms/api#RequestCMS
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드, (파트너 사이트에서 확인가능)
  $clientCode = '023030000004';

  // 출금동의 요청 정보 객체
  $KakaoCMS = new KakaoCMS();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $KakaoCMS->receiverHP = $KakaocertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $KakaoCMS->receiverName = $KakaocertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $KakaoCMS->receiverBirthday = $KakaocertService->encrypt('19700101');

  // 인증요청 메시지 제목 - 최대 40자
  $KakaoCMS->reqTitle = '인증요청 메시지 제공란';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $KakaoCMS->expireIn = 1000;
  // 청구기관명 - 최대 100자
  $KakaoCMS->requestCorp = $KakaocertService->encrypt('청구 기관명란');
  // 출금은행명 - 최대 100자
  $KakaoCMS->bankName = $KakaocertService->encrypt('출금은행명란');
  // 출금계좌번호 - 최대 32자
  $KakaoCMS->bankAccountNum = $KakaocertService->encrypt('9-4324-5117-58');
  // 출금계좌 예금주명 - 최대 100자
  $KakaoCMS->bankAccountName = $KakaocertService->encrypt('예금주명 입력란');
  // 출금계좌 예금주 생년월일 - 8자
  $KakaoCMS->bankAccountBirthday = $KakaocertService->encrypt('19700101');
  // 출금유형
  // CMS - 출금동의용, FIRM - 펌뱅킹, GIRO - 지로용
  $KakaoCMS->bankServiceType = $KakaocertService->encrypt('CMS'); // CMS, FIRM, GIRO

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $KakaoCMS->appUseYN = false; 

  // App to App 방식 이용시, 에러시 호출할 URL
  // $KakaoCMS->returnURL = 'https://kakao.barocert.com';


  try {
    $result = $KakaocertService->requestCMS($clientCode, $KakaoCMS);
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
