<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="/Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 전자서명 요청건에 대한 서명을 검증합니다.
  * - 
  */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드, (파트너 사이트에서 확인가능)
  $clientCode = '023020000003';

  // 전자서명 요청시 반환받은 접수아이디
  $receiptID = '0230310143306000000000000000000000000001';

  try {
    $result = $KakaocertService->bulkVerifyESign($clientCode, $receiptID);
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
                <legend>전자서명 검증(다건)</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                <li>요청 아이디 (RequestID) : <?php echo $result->requestID ?></li>

                <?php
                  for ($i = 0; $i < Count($result->bulkSignedData); $i++) {
                ?>

                  <li>전자서명 데이터 전문 (BulkSignedData) : <?php echo $result->bulkSignedData[$i] ?></li>

                <?php
                  }
                ?>

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
