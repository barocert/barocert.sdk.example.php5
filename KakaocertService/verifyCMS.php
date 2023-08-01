<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

  /*
   * 완료된 전자서명을 검증하고 전자서명값(signedData)을 반환 받습니다.
   * 카카오 보안정책에 따라 검증 API는 1회만 호출할 수 있습니다. 재시도시 오류가 반환됩니다.
   * 전자서명 완료일시로부터 10분 이내에 검증 API를 호출하지 않으면 오류가 반환됩니다.
   * https://developers.barocert.com/reference/kakao/php/cms/api#VerifyCMS
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023030000004';

  // 자동이체 출금동의 요청시 반환받은 접수아이디
  $receiptID = '02304120230300000040000000000023';

  try {
    $result = $KakaocertService->verifyCMS($clientCode, $receiptID);
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
                <legend>카카오 출금동의 검증</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                <li>상태 (State) : <?php echo $result->state ?></li>
                <li>전자서명 데이터 (SignedData) : <?php echo $result->signedData ?></li>
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
