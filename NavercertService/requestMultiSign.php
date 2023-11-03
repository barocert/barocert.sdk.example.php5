<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Naver Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 네이버톡 이용자에게 복수(최대 20건) 문서의 전자서명을 요청합니다.
   * https://developers.barocert.com/reference/naver/php/sign/api-multi#RequestMultiSign
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023060000088';

  // 전자서명 요청정보 객체
  $NaverMultiSign = new NaverMultiSign();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $NaverMultiSign->receiverHP = $NavercertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $NaverMultiSign->receiverName = $NavercertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $NaverMultiSign->receiverBirthday = $NavercertService->encrypt('19700101');

  // 인증요청 메시지 제목 - 최대 40자
  $NaverMultiSign->reqTitle = '전자서명(복수) 요청 메시지 제목';
  // 고객센터 연락처 - 최대 12자
  $NaverMultiSign->callCenterNum = '1600-9854';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $NaverMultiSign->expireIn = 1000;
  // 요청 메시지 - 최대 500자
  $NaverMultiSign->reqMessage = $NavercertService->encrypt('전자서명(복수) 요청 메시지');

  // 개별문서 등록 - 최대 50 건
  // 개별 요청 정보 객체
  $NaverMultiSign->tokens = array();
  
  $NaverMultiSign->tokens[] = new NaverMultiSignTokens();

  // 서명 원문 유형
  // TEXT - 일반 텍스트, HASH - HASH 데이터
  $NaverMultiSign->tokens[0]->tokenType = 'TEXT'; // TEXT, HASH
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $NaverMultiSign->tokens[0]->token = $NavercertService->encrypt("전자서명(복수) 요청 원문 1");

  $NaverMultiSign->tokens[] = new NaverMultiSignTokens();

  // 서명 원문 유형
  // TEXT - 일반 텍스트, HASH - HASH 데이터
  $NaverMultiSign->tokens[1]->tokenType = 'TEXT'; // TEXT, HASH
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $NaverMultiSign->tokens[1]->token = $NavercertService->encrypt("전자서명(복수) 요청 원문 2");

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $NaverMultiSign->appUseYN = false;

  // AppToApp 인증방식에서 사용
  // 모바일장비 유형('ANDROID', 'IOS'), 대문자 입력(대소문자 구분)
  // $PassIdentity->deviceOSType = 'IOS';

  // AppToApp 방식 이용시, 호출할 URL
  // $NaverMultiSign->returnURL = 'navercert://sign';

  try {
    $result = $NavercertService->requestMultiSign($clientCode, $NaverMultiSign);
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
                <legend>네이버 전자서명(복수) 요청</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수아이디 (TeceiptID) : <?php echo $result->receiptID ?></li>
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
