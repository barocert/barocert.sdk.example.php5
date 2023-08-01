<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Pass Service PHP 5.X Example.</title>
    </head>
<?php

  /*
  * 완료된 전자서명을 검증하고 전자서명값(signedData)을 반환 받습니다.
  * 검증 함수는 간편로그인 요청 함수를 호출한 당일 23시 59분 59초까지만 호출 가능합니다.
  * 간편로그인 요청 함수를 호출한 당일 23시 59분 59초 이후 검증 함수를 호출할 경우 오류가 반환됩니다.
  * https://developers.barocert.com/reference/pass/php/login/api#VerifyLogin
  */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023070000014';

  // 간편로그인 요청시 반환받은 접수아이디
  $receiptID = '02307280230700000140000000000005';

  // 간편로그인 검증 요청정보 객체
  $PassLoginVerify = new PassLoginVerify();

  $PassLoginVerify->receiverHP = $PasscertService->encrypt('01012341234');
  $PassLoginVerify->receiverName = $PasscertService->encrypt('홍길동');

  try {
    $result = $PasscertService->verifyLogin($clientCode, $receiptID, $PassLoginVerify);
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
                <legend>패스 간편로그인 검증</legend>
                <ul>
                <?php
                if ( isset($result) ) {
                ?>
                <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                <li>상태 (State) : <?php echo $result->state ?></li>
                <li>수신자 성명 (ReceiverName) : <?php echo $result->receiverName ?></li>
                <li>수신자 생년월일 (ReceiverBirthday) : <?php echo $result->receiverBirthday ?></li>
                <li>수신자 성별 (ReceiverGender) : <?php echo $result->receiverGender ?></li>
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
