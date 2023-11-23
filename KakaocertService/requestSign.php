<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 카카오톡 이용자에게 단건(1건) 문서의 전자서명을 요청합니다.
   * https://developers.barocert.com/reference/kakao/php/sign/api-single#RequestSign
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023040000001';

  // 전자서명 요청정보 객체
  $KakaoSign = new KakaoSign();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $KakaoSign->receiverHP = $KakaocertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $KakaoSign->receiverName = $KakaocertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $KakaoSign->receiverBirthday = $KakaocertService->encrypt('19700101');

  // 인증요청 메시지 제목 - 최대 40자
  $KakaoSign->signTitle = '전자서명(단건) 요청 메시지 제목';
  // 상세 설명 - 최대 500자
  $KakaoSign->extraMessage = $KakaocertService->encrypt("전자서명(단건) 상세 설명");
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $KakaoSign->expireIn = 1000;
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $KakaoSign->token = $KakaocertService->encrypt('전자서명(단건) 요청 원문');
  // 서명 원문 유형
  // TEXT - 일반 텍스트, HASH - HASH 데이터
  $KakaoSign->tokenType = 'TEXT'; // TEXT, HASH

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $KakaoSign->appUseYN = false;

  // App to App 방식 이용시, 호출할 URL
  // $KakaoSign->returnURL = 'https://kakao.barocert.com';

  try {
    $result = $KakaocertService->requestSign($clientCode, $KakaoSign);
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
                <legend>카카오 전자서명(단건) 요청</legend>
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
