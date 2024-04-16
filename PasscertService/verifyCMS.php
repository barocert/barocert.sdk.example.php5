<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php

  /*
   * 완료된 전자서명을 검증하고 전자서명값(signedData)을 반환 받습니다.
   * 검증 함수는 자동이체 출금동의 요청 함수를 호출한 당일 23시 59분 59초까지만 호출 가능합니다.
   * 자동이체 출금동의 요청 함수를 호출한 당일 23시 59분 59초 이후 검증 함수를 호출할 경우 오류가 반환됩니다.
   * https://developers.barocert.com/reference/pass/php/cms/api#VerifyCMS
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023070000014';

  // 출금동의 요청시 반환받은 접수아이디
  $receiptID = '02307280230700000140000000000002';

  // 출금동의 검증 요청정보 객체
  $PassCMSVerify = new PassCMSVerify();

  $PassCMSVerify->receiverHP = $PasscertService->encrypt('01012341234');
  $PassCMSVerify->receiverName = $PasscertService->encrypt('홍길동');

  try {
    $result = $PasscertService->verifyCMS($clientCode, $receiptID, $PassCMSVerify);
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
                <legend>패스 출금동의 검증 API JSP Example</legend>
                <ul>
                <?php
                if ( isset($result) ) {
                ?>
                  <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                  <li>상태 (State) : <?php echo $result->state ?></li>
                  <li>수신자 성명 (ReceiverName) : <?php echo $result->receiverName ?></li>
                  <li>수신자 출생년도 (ReceiverYear) : <?php echo $result->receiverYear ?></li>
                  <li>수신자 출생월일 (ReceiverDay) : <?php echo $result->receiverDay ?></li>
                  <li>수신자 성별 (ReceiverGender) : <?php echo $result->receiverGender ?></li>
                  <li>수신자 휴대폰번호 (ReceiverHP) : <?php echo $result->receiverHP ?></li>
                  <li>외국인 여부 (ReceiverForeign) : <?php echo $result->receiverForeign ?></li>
                  <li>수신자 통신사유형 (ReceiverTelcoType) : <?php echo $result->receiverTelcoType ?></li>
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
