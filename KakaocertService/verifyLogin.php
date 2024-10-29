<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php

  /*
   * 완료된 전자서명을 검증하고 전자서명 데이터 전문(signedData)을 반환 받습니다.
   * 카카오 보안정책에 따라 검증 API는 1회만 호출할 수 있습니다. 재시도시 오류가 반환됩니다.
   * 전자서명 완료일시로부터 10분 이후에 검증 API를 호출하면 오류가 반환됩니다.
   * https://developers.barocert.com/reference/kakao/php/login/api#VerifyLogin
   */

  include 'common.php';

  // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
  $clientCode = '023040000001';

  // 간편로그인 요청시 반환받은 트랜잭션 아이디
  $txID = '011798a371-538a-459a-87c9-0db65fdc1f2e';

  try {
    $result = $KakaocertService->verifyLogin($clientCode, $txID);
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
                <legend>카카오 간편로그인 검증</legend>
                <ul>
                <?php
                if ( isset($result) ) {
                ?>
                  <li>트랜잭션 아이디 (TxID) : <?php echo $result->txID ?></li>
                  <li>상태 (State) : <?php echo $result->state ?></li>
                  <li>전자서명 데이터 (SignedData) : <?php echo $result->signedData ?></li>
                  <li>연계정보 (Ci) : <?php echo $result->ci ?></li>
                  <li>수신자 성명 (ReceiverName) : <?php echo $result->receiverName ?></li>
                  <li>수신자 출생년도 (ReceiverYear) : <?php echo $result->receiverYear ?></li>
                  <li>수신자 출생월일 (ReceiverDay) : <?php echo $result->receiverDay ?></li>
                  <li>수신자 휴대폰번호 (ReceiverHP) : <?php echo $result->receiverHP ?></li>
                  <li>수신자 성별 (ReceiverGender) : <?php echo $result->receiverGender ?></li>
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
