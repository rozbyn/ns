Dim OldTime, TimeElapsed, N, I
OldTime = Timer
MsgBox "������� �� ����� ���������� ������", vbOKOnly, "������"
TimeElapsed = (Timer - OldTime)
N = TimeElapsed\60
i = TimeElapsed mod 60
msgbox "������ "&N&" �����, "&i&" ������."