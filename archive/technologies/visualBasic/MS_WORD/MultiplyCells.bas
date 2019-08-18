Attribute VB_Name = "NewMacros"
Sub multiplyCells()
'
' multiplyCells Макрос
'
'

Dim cellText, MyValue As String
Dim numb As Integer
Dim percent, newVal As Double


percent = Val(InputBox("Введите число множителя"))
If percent > 0 Then
Else
percent = 1.1
End If



For Each I In Selection.Cells
 cellText = I.Range.Text
' MsgBox (Asc(Right(cellText, 6)) & "-" & Right(cellText, 6))
 cellText = Replace(cellText, Chr(32), "", 1, -1, vbTextCompare)
 cellText = Replace(cellText, Chr(160), "", 1, -1, vbTextCompare)
 cellText = Replace(cellText, Chr(13), "", 1, -1, vbTextCompare)
 cellText = Replace(cellText, Chr(10), "", 1, -1, vbTextCompare)
 cellText = Replace(cellText, Chr(7), "", 1, -1, vbTextCompare)
 numb = Val(cellText)
 If numb > 0 Then
  newVal = numb * percent
  I.Range.Text = newVal
 End If
 
 
Next I



End Sub
