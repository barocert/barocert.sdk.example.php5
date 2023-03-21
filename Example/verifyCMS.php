<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 자동이체 출금동의 요청에 대한 서명을 검증합니다.
  * - 
  */

  include 'common.php';

  // 이용기관코드, 파트너 사이트에서 확인
  $clientCode = '023020000003';

  // 자동이체 출금동의 요청시 반환받은 접수아이디
  $receiptID = '0230309201738000000000000000000000000001';

  // 출금동의 AppToApp 방식에서 앱스킴으로 반환받은 서명값.
  // Talk Mesage 방식으로 출금동의 요청한 경우 null 처리.
  $signature = null;

  try {
    $result = $KakaocertService->verifyCMS($clientCode, $receiptID, $signature);
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
                <legend>본인인증 검증</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                <li>요청 아이디 (RequestID) : <?php echo $result->requestID ?></li>
                <li>상태 (State) : <?php echo $result->state ?></li>
                <li>전자서명 데이터 (signedData) : <?php echo $result->signedData ?></li>
                <li>연계정보 (Ci) : <?php echo $result->ci ?></li>
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
