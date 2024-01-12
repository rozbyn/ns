Dim OldTime, TimeElapsed, N, I
OldTime = Timer
MsgBox "Нажмите ОК чтобы остановить таймер", vbOKOnly, "Таймер"
TimeElapsed = (Timer - OldTime)
N = TimeElapsed\60
i = TimeElapsed mod 60
msgbox "Прошло "&N&" минут, "&i&" секунд."