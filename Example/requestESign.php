<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 전자서명 인증을 요청합니다.
  * - 
  */

  include 'common.php';

  // 이용기관코드, 파트너 사이트에서 확인
  $clientCode = '023020000003';

  // 전자서명 AppToApp 인증 여부
  // true-App To App 방식, false-Talk Message 방식
  $isAppUseYN = false;

  // 전자서명 요청정보 객체
  $RequestESign = new RequestESign();

  // 요청번호 40자
  $RequestESign->requestID = 'kakaocert_202303130000000000000000000005';

  // 수신자 정보(휴대폰번호, 성명, 생년월일)와 Ci 값 중 택일
  $RequestESign->receiverHP = '01087674117';
  $RequestESign->receiverName = '이승환';
  $RequestESign->receiverBirthday = '19930112';
  // $RequestESign->ci = '';

  $RequestESign->reqTitle = '전자서명단건테스트';
  $RequestESign->expireIn = 1000;
  $RequestESign->token = '전자서명단건테스트데이터';
  $RequestESign->tokenType = 'TEXT'; // TEXT, HASH

  // App to App 방식 이용시, 에러시 호출할 URL
  // $RequestESign->returnURL = 'https://kakao.barocert.com';

  try {
    $result = $KakaocertService->requestESign($clientCode, $RequestESign, $isAppUseYN);
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
                <legend>전자서명 요청(단건)</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수아이디 (receiptId) : <?php echo $result->receiptId ?></li>
                <li>앱스킴 (scheme)[AppToApp 앱스킴 호출용] : <?php echo $result->scheme ?></li>
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
