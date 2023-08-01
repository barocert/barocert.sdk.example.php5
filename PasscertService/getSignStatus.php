<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Pass Service PHP 5.X Example.</title>
    </head>
<?php

    /*
     * 전자서명 요청 후 반환받은 접수아이디로 인증 진행 상태를 확인합니다.
     * 상태확인 함수는 전자서명 요청 함수를 호출한 당일 23시 59분 59초까지만 호출 가능합니다.
     * 전자서명 요청 함수를 호출한 당일 23시 59분 59초 이후 상태확인 함수를 호출할 경우 오류가 반환됩니다.
     * https://developers.barocert.com/reference/pass/php/sign/api#GetSignStatus
     */

    include 'common.php';

    // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
    $clientCode = '023070000014';

    // 전자서명 요청시 반환받은 접수아이디
    $receiptID = '02307280230700000140000000000001';

    try {
        $result = $PasscertService->getSignStatus($clientCode, $receiptID);
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
                <legend>패스 전자서명 상태확인</legend>
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
                    <li>요청 만료시간 (ExpireIn) : <?php echo $result->expireIn ?></li>
                    <li>이용기관 명 (CallCenterName) : <?php echo $result->callCenterName ?></li>
                    <li>이용기관 연락처 (CallCenterNum) : <?php echo $result->callCenterNum ?></li>
                    <li>인증요청 메시지 제목 (ReqTitle) : <?php echo $result->reqTitle ?></li>
                    <li>인증요청 메시지 제목 (reqMessage) : <?php echo $result->reqMessage ?></li>
                    <li>서명요청일시 (RequestDT) : <?php echo $result->requestDT ?></li>
                    <li>서명완료일시 (CompleteDT) : <?php echo $result->completeDT ?></li>
                    <li>서명만료일시 (ExpireDT) : <?php echo $result->expireDT ?></li>
                    <li>서명거절일시 (RejectDT) : <?php echo $result->rejectDT ?></li>
                    <li>원문 유형 (TokenType) : <?php echo $result->tokenType ?></li>
                    <li>사용자동의필요여부 (UserAgreementYN) : <?php echo $result->userAgreementYN ?></li>
                    <li>사용자정보포함여부 (ReceiverInfoYN) : <?php echo $result->receiverInfoYN ?></li>
                    <li>통신사 유형 (TelcoType) : <?php echo $result->telcoType ?></li>
                    <li>모바일장비 유형 (DeviceOSType) : <?php echo $result->deviceOSType ?></li>
                    <li>원본유형코드 (originalTypeCode) : <?php echo $result->originalTypeCode ?></li>
                    <li>원본조회URL (originalURL) : <?php echo $result->originalURL ?></li>
                    <li>원본형태코드 (originalFormatCode) : <?php echo $result->originalFormatCode ?></li>
                    <li>앱스킴 (Scheme) : <?php echo $result->scheme ?></li>
                    <li>앱사용유무 (AppUseYN) : <?php echo var_dump($result->appUseYN) ?></li>
                    <?php
                    }
                    ?>
                </ul>
            </fieldset>
        </div>
    </body>
</html
