<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 카카오톡 사용자에게 출금동의 전자서명을 요청합니다.
  */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드, (파트너 사이트에서 확인가능)
  $clientCode = '023030000004';

  // 출금동의 요청 정보 객체
  $RequestCMS = new RequestCMS();

  // 수신자 정보
  // 휴대폰번호,성명,생년월일 또는 Ci(연계정보)값 중 택 일
  $RequestCMS->receiverHP = $KakaocertService->encrypt('01054437896');
  $RequestCMS->receiverName = $KakaocertService->encrypt('최상혁');
  $RequestCMS->receiverBirthday = $KakaocertService->encrypt('19880301');
  // $RequestCMS->ci = KakaocertService::encrypt('');;

  // 인증요청 메시지 제목 - 최대 40자
  $RequestCMS->reqTitle = '인증요청 메시지 제공란';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $RequestCMS->expireIn = 1000;
  // 청구기관명 - 최대 100자
  $RequestCMS->requestCorp = $KakaocertService->encrypt('청구 기관명란');
  // 출금은행명 - 최대 100자
  $RequestCMS->bankName = $KakaocertService->encrypt('출금은행명란');
  // 출금계좌번호 - 최대 32자
  $RequestCMS->bankAccountNum = $KakaocertService->encrypt('9-4324-5117-58');
  // 출금계좌 예금주명 - 최대 100자
  $RequestCMS->bankAccountName = $KakaocertService->encrypt('예금주명 입력란');
  // 출금계좌 예금주 생년월일 - 8자
  $RequestCMS->bankAccountBirthday = $KakaocertService->encrypt('19880301');
  // 출금유형
  // CMS - 출금동의용, FIRM - 펌뱅킹, GIRO - 지로용
  $RequestCMS->bankServiceType = $KakaocertService->encrypt('CMS'); // CMS, FIRM, GIRO

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $RequestCMS->appUseYN = false; 

  // App to App 방식 이용시, 에러시 호출할 URL
  // $RequestCMS->returnURL = 'https://kakao.barocert.com';


  try {
    $result = $KakaocertService->requestCMS($clientCode, $RequestCMS);
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
