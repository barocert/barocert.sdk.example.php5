<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 카카오톡 사용자에게 전자서명을 요청합니다.(복수)
  */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드, (파트너 사이트에서 확인가능)
  $clientCode = '023030000004';

  // 전자서명 요청정보 객체
  $RequestMultiSign = new RequestMultiSign();

  // 수신자 정보
  // 휴대폰번호,성명,생년월일 또는 Ci(연계정보)값 중 택 일
  $RequestMultiSign->receiverHP = $KakaocertService->encrypt('01054437896');
  $RequestMultiSign->receiverName = $KakaocertService->encrypt('최상혁');
  $RequestMultiSign->receiverBirthday = $KakaocertService->encrypt('19880301');
  // $RequestMultiSign->ci = $KakaocertService->encrypt('');

    // 인증요청 메시지 제목 - 최대 40자
  $RequestMultiSign->reqTitle = '전자서명단건테스트';
  // 인증요청 만료시간 - 최대 1,000(초)까지 입력 가능
  $RequestMultiSign->expireIn = 1000;

  // 개별문서 등록 - 최대 20 건
  // 개별 요청 정보 객체
  $RequestMultiSign->tokens = array();
  
  $RequestMultiSign->tokens[] = new MultiSignTokens();
  // 인증요청 메시지 제목 - 최대 40자
  $RequestMultiSign->tokens[0]->reqTitle = "전자서명복수문서테스트1";
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $RequestMultiSign->tokens[0]->token = $KakaocertService->encrypt("전자서명복수테스트데이터1");

  $RequestMultiSign->tokens[] = new MultiSignTokens();
  // 인증요청 메시지 제목 - 최대 40자
  $RequestMultiSign->tokens[1]->reqTitle = "전자서명복수문서테스트2";
  // 서명 원문 - 원문 2,800자 까지 입력가능
  $RequestMultiSign->tokens[1]->token = $KakaocertService->encrypt("전자서명복수테스트데이터2");

  // 서명 원문 유형
  // TEXT - 일반 텍스트, HASH - HASH 데이터
  $RequestMultiSign->tokenType = 'TEXT'; // TEXT, HASH

  // AppToApp 인증요청 여부
  // true - AppToApp 인증방식, false - Talk Message 인증방식
  $RequestMultiSign->appUseYN = false;

  // App to App 방식 이용시, 에러시 호출할 URL
  // $RequestMultiSign->returnURL = 'https://kakao.barocert.com';

  try {
    $result = $KakaocertService->requestMultiSign($clientCode, $RequestMultiSign);
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
                <legend>전자서명 요청(복수)</legend>
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
