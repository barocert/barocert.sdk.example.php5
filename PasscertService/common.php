<?php
  /**
  * Passcert API PHP SDK Example
  *
  * 업데이트 일자 : 2023-07-26
  * 연동기술지원 연락처 : 1600-9854
  * 연동기술지원 이메일 : dev@linkhubcorp.com
  *
  */

    require_once '../Barocert/Passcert.php';

    // 링크아이디
    $LinkID = 'TESTER';

    // 비밀키
    $SecretKey = 'SwWxqU+0TErBXy/9TVjIPEnI0VTUMMSQZtJf3Ed8q3I=';

    // 통신방식 기본은 CURL , curl 사용에 문제가 있을경우 STREAM 사용가능.
    // STREAM 사용시에는 php.ini의 allow_url_fopen = on 으로 설정해야함.
    define('LINKHUB_COMM_MODE','CURL');

    $PasscertService = new PasscertService($LinkID, $SecretKey);

    // 인증토큰에 대한 IP제한기능 사용여부, 권장(true)
    $PasscertService->IPRestrictOnOff(true);

    // 패스써트 API 서비스 고정 IP 사용여부, 기본값(false)
    $PasscertService->UseStaticIP(false);

    // 로컬시스템 시간 사용 여부 true(기본값) - 사용, false(미사용)
    $PasscertService->UseLocalTimeYN(true);

?>
