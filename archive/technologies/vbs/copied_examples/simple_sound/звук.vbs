Option Explicit

' Стандартные форматы PCM
Const SAFT8kHz8BitMono = 4
Const SAFT8kHz8BitStereo = 5
Const SAFT8kHz16BitMono = 6
Const SAFT8kHz16BitStereo = 7
Const SAFT11kHz8BitMono = 8
Const SAFT11kHz8BitStereo = 9
Const SAFT11kHz16BitMono = 10
Const SAFT11kHz16BitStereo = 11
Const SAFT12kHz8BitMono = 12
Const SAFT12kHz8BitStereo = 13
Const SAFT12kHz16BitMono = 14
Const SAFT12kHz16BitStereo = 15
Const SAFT16kHz8BitMono = 16
Const SAFT16kHz8BitStereo = 17
Const SAFT16kHz16BitMono = 18
Const SAFT16kHz16BitStereo = 19
Const SAFT22kHz8BitMono = 20
Const SAFT22kHz8BitStereo = 21
Const SAFT22kHz16BitMono = 22
Const SAFT22kHz16BitStereo = 23
Const SAFT24kHz8BitMono = 24
Const SAFT24kHz8BitStereo = 25
Const SAFT24kHz16BitMono = 26
Const SAFT24kHz16BitStereo = 27
Const SAFT32kHz8BitMono = 28
Const SAFT32kHz8BitStereo = 29
Const SAFT32kHz16BitMono = 30
Const SAFT32kHz16BitStereo = 31
Const SAFT44kHz8BitMono = 32
Const SAFT44kHz8BitStereo = 33
Const SAFT44kHz16BitMono = 34
Const SAFT44kHz16BitStereo = 35
Const SAFT48kHz8BitMono = 36
Const SAFT48kHz8BitStereo = 37
Const SAFT48kHz16BitMono = 38
Const SAFT48kHz16BitStereo = 39
Dim objNotes, lngSpAudioFormat, dblSndDur, dblSndDelay, dblSndFadeCut, dblSndVolume, lngSamplingFrequency, arrSounds, arrSamples1, objStream1, arrSamples2, objStream2

' вычисленние частот каждой ноты
Set objNotes = GetPitches()

' установка параметров звука
lngSpAudioFormat = SAFT16kHz16BitMono ' формат
dblSndDur = 3 ' длительность звука в секундах
dblSndDelay = 0.45 ' задержка между звуками в секундах
dblSndFadeCut = 0.001 ' уровень отсечки
dblSndVolume = 0.5 ' громкость
lngSpAudioFormat = lngSpAudioFormat And 254 ' принудительно моно
lngSamplingFrequency = Array(8000, 11000, 12000, 16000, 22000, 24000, 32000, 44000, 48000)((lngSpAudioFormat - 4) \ 4) ' определение частоты дискретизации в Гц

arrSounds = Array("Соль-диез 1 октава", "До 2 октава", "Ре-диез 2 октава", "Соль-диез 2 октава") ' частоты звуков в Гц / названия нот
RenderSound lngSamplingFrequency, arrSounds, dblSndDur, dblSndDelay, dblSndFadeCut, arrSamples1
arrSounds = Array("Соль-диез 2 октава", "Ре-диез 2 октава", "До 2 октава", "Соль-диез 1 октава")
RenderSound lngSamplingFrequency, arrSounds, dblSndDur, dblSndDelay, dblSndFadeCut, arrSamples2
Set objStream1 = CreateSpMemStream(lngSpAudioFormat, arrSamples1, dblSndVolume)
Set objStream2 = CreateSpMemStream(lngSpAudioFormat, arrSamples2, dblSndVolume)

PlaySound objStream1
CreateObject("WScript.Shell").PopUp "Press OK to continue", 0, , 64
PlaySound objStream2

Sub PlaySound(objSpMemStream)
    objSpMemStream.Seek 0
    With CreateObject("SAPI.SpVoice")
        .SpeakStream objSpMemStream, 1
        .WaitUntilDone -1
    End With
End Sub

Sub RenderSound(lngSamplingFrequency, arrSounds, dblSndDur, dblSndDelay, dblSndFadeCut, arrSamples)
    Dim n, dblSndFreq, lngDelaySamples, arrTone
    ' генерация и смешивание звуков
    lngDelaySamples = CLng(dblSndDelay * lngSamplingFrequency)
    arrSamples = Array()
    For n = 0 To UBound(arrSounds)
        If IsNumeric(arrSounds(n)) Then dblSndFreq = arrSounds(n) Else dblSndFreq = objNotes(arrSounds(n))
        GenerateTone dblSndFreq, dblSndDur, dblSndFadeCut, lngSamplingFrequency, arrTone
        Mix arrSamples, arrTone, 1, n * lngDelaySamples
    Next
    ' наложение эхо
    Echo arrSamples, lngSamplingFrequency, 12
    ' нормализация
    Normalize arrSamples
    ' обрезка тишины в конце
    TrimSilence arrSamples, dblSndFadeCut
End Sub

Sub GenerateTone(dblSndFreq, dblSndDur, dblSndFadeCut, lngSamplingFrequency, arrSamples)
    Dim i, dblPi, dblRadsPerSample, lngTotalSamples, lngFadeInSamples, lngFadeOutSamples, dblFadeIn, dblFadeOut, dblAmplitude
    ' определение параметров звука
    dblPi = 4 * Atn(1)
    dblRadsPerSample = 2 * dblPi * dblSndFreq / lngSamplingFrequency ' radians per sample
    lngTotalSamples = CLng(dblSndDur * lngSamplingFrequency)
    lngFadeInSamples = CLng(lngTotalSamples * 0.01)
    lngFadeOutSamples = lngTotalSamples - lngFadeInSamples
    dblFadeIn = 1 / Exp(Log(dblSndFadeCut) / lngFadeInSamples)
    dblFadeOut = Exp(Log(dblSndFadeCut) / lngFadeOutSamples)
    arrSamples = Array()
    ReDim arrSamples(lngTotalSamples - 1)
    ' генерация нарастания
    dblAmplitude = dblSndFadeCut
    For i = 0 To lngFadeInSamples - 1
        arrSamples(i) = dblAmplitude * (Sin(i * dblRadsPerSample) + 0.5 * Sin(2 * i * dblRadsPerSample) + 0.15 * Sin(4 * i * dblRadsPerSample))
        ' arrSamples(i) = dblAmplitude * Sin(i * dblRadsPerSample)
        dblAmplitude = dblAmplitude * dblFadeIn
    Next
    ' генерация спада
    dblAmplitude = 1
    For i = lngFadeInSamples To lngTotalSamples - 1
        arrSamples(i) = dblAmplitude * (Sin(i * dblRadsPerSample) + 0.5 * Sin(2 * i * dblRadsPerSample) + 0.15 * Sin(4 * i * dblRadsPerSample))
        ' arrSamples(i) = dblAmplitude * Sin(i * dblRadsPerSample)
        dblAmplitude = dblAmplitude * dblFadeOut
    Next
End Sub

Sub Mix(arrSamples, arrMixing, dblGain, lngDelaySamples)
    Dim i, lngAddSamples
    lngAddSamples = lngDelaySamples + UBound(arrMixing)
    If lngAddSamples > UBound(arrSamples) Then ReDim Preserve arrSamples(lngAddSamples)
    For i = 0 To UBound(arrMixing)
        arrSamples(i + lngDelaySamples) = arrSamples(i + lngDelaySamples) + dblGain * arrMixing(i)
    Next
End Sub

Sub Echo(arrSamples, lngSamplingFrequency, lngDepth)
    Dim n, dblDelay, lngOffset, dblAttenuation, arrReplica
    For n = 1 To lngDepth
        Randomize
        dblDelay = 0.2 + Rnd * 0.7 ' задержка эхо в секундах
        lngOffset = CLng(lngSamplingFrequency * dblDelay)
        dblAttenuation = 10 ^ -(0.75 + Rnd * 0.6) ' уровень ослабления
        arrReplica = arrSamples
        Mix arrSamples, arrReplica, dblAttenuation, lngOffset
    Next
End Sub

Sub Normalize(arrSamples)
    Dim dblPeak, dblRatio, i
    dblPeak = 0
    For i = 0 To UBound(arrSamples)
        If Abs(arrSamples(i)) > dblPeak Then dblPeak = Abs(arrSamples(i))
    Next
    dblRatio = 1 / dblPeak
    For i = 0 To UBound(arrSamples)
        arrSamples(i) = arrSamples(i) * dblRatio
    Next
End Sub

Sub TrimSilence(arrSamples, dblSndFadeCut)
    Dim i
    For i = UBound(arrSamples) To 0 Step -1
        If Abs(arrSamples(i)) > dblSndFadeCut Then Exit For
    Next
    ReDim Preserve arrSamples(i)
End Sub

Function CreateSpMemStream(lngSpAudioFormat, arrSamples, dblSndVolume)
    Dim bool16Bit, lngMax, dblAmplitude, lngValue, lngMSB, lngLSB, i
    ' создание потока
    Set CreateSpMemStream = CreateObject("SAPI.SpMemoryStream")
    CreateSpMemStream.Format.Type = lngSpAudioFormat
    bool16Bit = (lngSpAudioFormat \ 2) Mod 2 ' определение разрядности 8 / 16 бит
    ' преобразование величин и заполнение потока
    If bool16Bit Then ' 16 бит
        lngMax = 2 ^ 15 - 1 ' 32767
        dblAmplitude = dblSndVolume * lngMax
        For i = 0 To UBound(arrSamples)
            lngValue = Fix(arrSamples(i) * dblAmplitude)
            If lngValue < 0 Then lngValue = 65536 + lngValue
            lngMSB = lngValue \ 256
            lngLSB = lngValue Mod 256
            CreateSpMemStream.Write CByte(lngLSB)
            CreateSpMemStream.Write CByte(lngMSB)
        Next
    Else ' 8 бит
        lngMax = 2 ^ 7 - 1
        dblAmplitude = dblSndVolume * lngMax
        For i = 0 To UBound(arrSamples)
            CreateSpMemStream.Write CByte(arrSamples(i) * dblAmplitude + lngMax)
        Next
    End If
End Function

Function GetPitches()
    Dim objDictionary, n, m, f
    Set objDictionary = CreateObject("Scripting.Dictionary")
    For m = 0 To 8 ' октавы
        For n = 0 To 11 ' ноты
            f = 27.5 * 2 ^ (m + (n - 9) / 12)
            objDictionary(Array("C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B")(n) & m) = f ' scientific pitch notation
            objDictionary(Array("До", "До-диез", "Ре", "Ре-диез", "Ми", "Фа", "Фа-диез", "Соль", "Соль-диез", "Ля", "Ля-диез", "Си")(n) & " " & Array("Субконтpоктава", "Контpоктава", "Большая октава", "Малая октава", "1 октава", "2 октава", "3 октава", "4 октава", "5 октава")(m)) = f
        Next
    Next
    Set GetPitches = objDictionary
End Function