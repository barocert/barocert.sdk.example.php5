<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../Example.css" media="screen" />
        <title>Barocert Pass Service PHP 5.X Example.</title>
    </head>
<?php

    /*
     * 패스 이용자에게 문서의 전자서명을 요청합니다.
     * https://developers.barocert.com/reference/pass/php/sign/api#RequestSign
     */

    include 'common.php';

    // 이용기관코드, 파트너가 등록한 이용기관의 코드 (파트너 사이트에서 확인가능)
    $clientCode = '023070000014';

    // 전자서명 요청정보 객체
    $PassSign = new PassSign();

    // 수신자 휴대폰번호 - 11자 (하이픈 제외)
    $PassSign->receiverHP = $PasscertService->encrypt('01012341234');
    // 수신자 성명 - 80자
    $PassSign->receiverName = $PasscertService->encrypt('홍길동');
    // 수신자 생년월일 - 8자 (yyyyMMdd)
    $PassSign->receiverBirthday = $PasscertService->encrypt('19700101');

    // 요청 메시지 제목 - 최대 40자
    $PassSign->reqTitle = '전자서명 요청 메시지 제목';
    // 요청 메시지 - 최대 500자
    $PassSign->reqMessage = $PasscertService->encrypt('전자서명 요청 메시지');
    // 고객센터 연락처 - 최대 12자
    $PassSign->callCenterNum = '1600-9854';
    // 요청 만료시간 - 최대 1,000(초)까지 입력 가능
    $PassSign->expireIn = 1000;
    // 서명 원문 - 원문 2,800자 까지 입력가능
    $PassSign->token = $PasscertService->encrypt('전자서명 요청 원문');
    // 서명 원문 유형
    // 'TEXT' - 일반 텍스트, 'HASH' - HASH 데이터, 'URL' - URL 데이터
    // 원본데이터(originalTypeCode, originalURL, originalFormatCode) 입력시 'TEXT'사용 불가
    $PassSign->tokenType = 'URL';

    // 사용자 동의 필요 여부
    $PassSign->userAgreementYN = true;
    // 사용자 정보 포함 여부
    $PassSign->receiverInfoYN = true;

    // 원본유형코드
    // 'AG' - 동의서, 'AP' - 신청서, 'CT' - 계약서, 'GD' - 안내서, 'NT' - 통지서, 'TR' - 약관
    $PassSign->originalTypeCode = 'TR';
    // 원본조회URL
    $PassSign->originalURL = 'https://www.passcert.co.kr';
    // 원본형태코드
    // ('TEXT', 'HTML', 'DOWNLOAD_IMAGE', 'DOWNLOAD_DOCUMENT')
    $PassSign->originalFormatCode = 'HTML';

    // AppToApp 요청 여부
    // true - AppToApp 인증방식, false - 푸시(Push) 인증방식
    $PassSign->appUseYN = false;
    // ApptoApp 인증방식에서 사용
    // 통신사 유형('SKT', 'KT', 'LGU'), 대문자 입력(대소문자 구분)
    // $PassSign->telcoType = 'SKT';
    // ApptoApp 인증방식에서 사용
    // 모바일장비 유형('ANDROID', 'IOS'), 대문자 입력(대소문자 구분)
    // $PassSign->deviceOSType = 'IOS';

    try {
        $result = $PasscertService->requestSign($clientCode, $PassSign);
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
                <legend>패스 전자서명 요청</legend>
                <ul>

                <?php
                if ( isset($result) ) {
                ?>
                <li>접수아이디 (ReceiptID) : <?php echo $result->receiptID ?></li>
                <li>앱스킴 (Scheme) : <?php echo $result->scheme ?></li>
                <li>앱다운로드URL (marketUrl) : <?php echo $result->marketUrl ?></li>
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
