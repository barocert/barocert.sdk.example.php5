<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php

  /*
   * 완료된 전자서명을 검증하고 전자서명값(signedData)을 반환 받습니다.
   * 카카오 보안정책에 따라 검증 API는 1회만 호출할 수 있습니다. 재시도시 오류가 반환됩니다.
   * 전자서명 완료일시로부터 10분 이후에 검증 API를 호출하면 오류가 반환됩니다.
   * https://developers.barocert.com/reference/kakao/php/sign/api-multi#VerifyMultiSign
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023040000001';

  // 전자서명 요청시 반환받은 접수아이디
  $receiptID = '02304120230300000040000000000026';

  try {
    $result = $KakaocertService->verifyMultiSign($clientCode, $receiptID);
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
                <legend>카카오 전자서명(복수) 검증</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                  <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                  <li>상태 (State) : <?php echo $result->state ?></li>

                <?php
                  for ($i = 0; $i < Count($result->multiSignedData); $i++) {
                ?>

                  <li>전자서명 데이터 전문 (multiSignedData) : <?php echo $result->multiSignedData[$i] ?></li>

                <?php
                  }
                ?>

                  <li>연계정보 (Ci) : <?php echo $result->ci ?></li>
                  <li>수신자 성명 (ReceiverName) : <?php echo $result->receiverName ?></li>
                  <li>수신자 출생년도 (ReceiverYear) : <?php echo $result->receiverYear ?></li>
                  <li>수신자 출생월일 (ReceiverDay) : <?php echo $result->receiverDay ?></li>
                  <li>수신자 휴대폰번호 (ReceiverHP) : <?php echo $result->receiverHP ?></li>
                  <li>수신자 성별 (ReceiverGender) : <?php echo $result->receiverGender ?></li>
                  <li>외국인 여부 (ReceiverForeign) : <?php echo $result->receiverForeign ?></li>
                  <li>통신사 유형 (ReceiverTelcoType) : <?php echo $result->receiverTelcoType ?></li>
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
