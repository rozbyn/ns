<?php ## "��������" ��������.
  // ����������� � Web-�������� localhost. �������� ��������,
  // ��� ������� "http://" �� ������������ - ���������� � ��������� 
  // � ��� ���������� � ������ ����� (80).
  $fp = fsockopen("ya.ru", 443);
  // �������� ������ ������� �������� �������. ����� ������
  // � ���� "\r\n" ������������� ��������� ��������� HTTP.

  if($fp === false){
    exit('no connection!');
  }
  // �������� ������������ ��� HTTP 1.1 ��������� Host.
  fputs($fp, "GET https://ya.ru/ HTTP/1.1\r\n");
  fputs($fp, "Host: ya.ru\r\n");
  // ��������� ����� Keep-alive, ��� ���������� ������ ����� �� ������� 
  // ���������� ����� ������� ������, � �� ������� ���������� �������. 
  // ���������� ������ ��� ������� - � ������ ������� ������ ����������.
  fputs($fp, "Connection: close\r\n");
  // ����� ����������.
  fputs($fp, "\r\n");
  // ������ ������ �� ����� ������ � ������� �����.
  echo "<pre>";
  $i = 0;
  $readBody = false;
  $body = '';
  while (!feof($fp) && $i < 1000){
    $a = fgets($fp, 1000);
    if($a === "\r\n") {
      $readBody = true;
    }
    if ($readBody) {
      $body .= $a;
    } else {
      echo htmlspecialchars($a);
    }
    $i++;
  }
  echo $body;
  echo "</pre>";
  // ����������� �� �������.
  fclose($fp);
?>