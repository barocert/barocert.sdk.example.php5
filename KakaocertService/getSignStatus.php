<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Kakao Service PHP 5.X Example.</title>
    </head>
<?php

    /*
     * 전자서명(단건) 요청 후 반환받은 접수아이디로 인증 진행 상태를 확인합니다.
     * https://developers.barocert.com/reference/kakao/php/sign/api-single#GetSignStatus
     */

    include 'common.php';

    // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
    $clientCode = '023040000001';

    // 전자서명 요청시 반환받은 접수아이디
    $receiptID = '02304120230300000040000000000028';

    try {
        $result = $KakaocertService->getSignStatus($clientCode, $receiptID);
    }
    catch(BarocertException $ke) {
        $code = $ke->getCode();
        $message = $ke->getMessage();
    }
?>
    <body>
        <div id="content">
            <p class="heading1">Response</p>
            <br/>
            <fieldset class="fieldset1">
                <legend>카카오 전자서명(단건) 요청</legend>
                <ul>
                    <?php
                    if ( isset($code) ) {
                    ?>
                        <li>Response.code : <?php echo $code ?> </li>
                        <li>Response.message : <?php echo $message ?></li>
                    <?php
                    } else {
                    ?>
                        <li>접수 아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                        <li>이용기관 코드 (ClientCode) : <?php echo $result->clientCode ?></li>
                        <li>상태 (State) : <?php echo $result->state ?></li>
                        <li>서명요청일시 (RequestDT) : <?php echo $result->requestDT ?></li>
                        <li>서명조회일시 (ViewDT) : <?php echo $result->viewDT ?></li>
                        <li>서명완료일시 (CompleteDT) : <?php echo $result->completeDT ?></li>
                        <li>서명만료일시 (ExpireDT) : <?php echo $result->expireDT ?></li>
                        <li>서명검증일시 (VerifyDT) : <?php echo $result->verifyDT ?></li>
                    <?php
                    }
                    ?>
                </ul>
            </fieldset>
        </div>
    </body>
</html
