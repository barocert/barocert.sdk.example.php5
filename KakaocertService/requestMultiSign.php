<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php

  /*
   * 카카오톡 이용자에게 복수(최대 20건) 문서의 전자서명을 요청합니다.
   * https://developers.barocert.com/reference/kakao/php/sign/api-multi#RequestMultiSign
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023040000001';

  // 전자서명 요청정보 객체
  $KakaoMultiSign = new KakaoMultiSign();

  // 수신자 휴대폰번호 - 11자 (하이픈 제외)
  $KakaoMultiSign->receiverHP = $KakaocertService->encrypt('01012341234');
  // 수신자 성명 - 80자
  $KakaoMultiSign->receiverName = $KakaocertService->encrypt('홍길동');
  // 수신자 생년월일 - 8자 (yyyyMMdd)
  $KakaoMultiSign->receiverBirthday = $KakaocertService->encrypt('19700101');

    // 인증요청 메시지 제목 - 최대 40자
  $KakaoMultiSign->reqTitle = '전자서명(복수) 요청 메시지 제목';
  // 커스텀 메시지 - 최대 500자
  $KakaoMultiSign->extraMessage = $KakaocertService->encrypt("전자서명(복수) 커스텀 메시지");
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $KakaoMultiSign->expireIn = 1000;

  // 개별문서 등록 - 최대 20 건
  // 개별 요청 정보 객체
  $KakaoMultiSign->tokens = array();
  
  $KakaoMultiSign->tokens[] = new KakaoMultiSignTokens();
  // 서명 요청 제목 - 최대 40자
  $KakaoMultiSign->tokens[0]->signTitle = "전자서명(복수) 서명 요청 제목 1";
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $KakaoMultiSign->tokens[0]->token = $KakaocertService->encrypt("전자서명(복수) 요청 원문 1");
  // 서명 원문 유형이 HASH인 경우, 원문은 SHA-256, Base64 URL Safe No Padding을 사용
  // $KakaoMultiSign->token[0] = $KakaocertService->encrypt($KakaocertService->sha256_base64url_file($target));


  $KakaoMultiSign->tokens[] = new KakaoMultiSignTokens();
  // 서명 요청 제목 - 최대 40자
  $KakaoMultiSign->tokens[1]->signTitle = "전자서명(복수) 서명 요청 제목 2";
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $KakaoMultiSign->tokens[1]->token = $KakaocertService->encrypt("전자서명(복수) 요청 원문 2");
  // 서명 원문 유형이 HASH인 경우, 원문은 SHA-256, Base64 URL Safe No Padding을 사용
  // $KakaoMultiSign->token[1] = $KakaocertService->encrypt($KakaocertService->sha256_base64url_file($target));


  // 서명 원문 유형
  // TEXT - 일반 텍스트, HASH - HASH 데이터, PDF - PDF 데이터
  $KakaoMultiSign->tokenType = 'TEXT'; // TEXT, HASH, PDF
  // $KakaoSign->tokenType = 'PDF';

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $KakaoMultiSign->appUseYN = false;

  // App to App 방식 이용시, 호출할 URL
  // $KakaoMultiSign->returnURL = 'https://kakao.barocert.com';

  try {
    $result = $KakaocertService->requestMultiSign($clientCode, $KakaoMultiSign);
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
                <legend>카카오 전자서명(복수) 요청</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                  <li>접수아이디 (TeceiptID) : <?php echo $result->receiptID ?></li>
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
