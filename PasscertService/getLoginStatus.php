<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert PHP Example</title>
    </head>
<?php
    /*
     * 간편로그인 요청 후 반환받은 접수아이디로 진행 상태를 확인합니다.
     * 상태확인 함수는 간편로그인 요청 함수를 호출한 당일 23시 59분 59초까지만 호출 가능합니다.
     * 간편로그인 요청 함수를 호출한 당일 23시 59분 59초 이후 상태확인 함수를 호출할 경우 오류가 반환됩니다.
     * https://developers.barocert.com/reference/pass/php/login/api#GetLoginStatus
     */

    include 'common.php';

    // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
    $clientCode = '023070000014';

    // 간편로그인 요청시 반환된 접수아이디
    $receiptID = '02307280230700000140000000000005';

    try {
        $result = $PasscertService->getLoginStatus($clientCode, $receiptID);
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
                <legend>패스 간편로그인 상태확인</legend>
                <ul>
                    <?php
                    if ( isset($code) ) {
                    ?>
                        <li>Response.code : <?php echo $code ?> </li>
                        <li>Response.message : <?php echo $message ?></li>
                    <?php
                    } else {
                    ?>
                        <li>이용기관 코드 (ClientCode) : <?php echo $result->clientCode ?></li>
                        <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                        <li>상태 (State) : <?php echo $result->state ?></li>
                        <li>서명요청일시 (RequestDT) : <?php echo $result->requestDT ?></li>
                        <li>서명완료일시 (CompleteDT) : <?php echo $result->completeDT ?></li>
                        <li>서명만료일시 (ExpireDT) : <?php echo $result->expireDT ?></li>
                        <li>서명거절일시 (RejectDT) : <?php echo $result->rejectDT ?></li>
                    <?php
                    }
                    ?>
                </ul>
            </fieldset>
        </div>
    </body>
</html
