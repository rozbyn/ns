Attribute VB_Name = "RecordedMacros"


Sub saed22()
    ' Recorded 20.05.2016
    Dim grp1 As ShapeRange
    Set grp1 = ActiveDocument.Pages(6).Layers("???? 1").Shapes(1).Shapes(1).UngroupEx
    ActiveDocument.Pages(6).Shapes.All.CreateSelection
    Dim grp2 As ShapeRange
    Set grp2 = ActiveSelection.UngroupEx
    Dim grp3 As ShapeRange
    Set grp3 = grp2(3).UngroupEx
    Dim grp4 As ShapeRange
    Set grp4 = grp2(2).UngroupEx
    Dim grp5 As ShapeRange
    Set grp5 = grp2(1).UngroupEx
    grp2(7).Bitmap.ConvertTo cdrGrayscaleImage
    grp2(5).Bitmap.ConvertTo cdrGrayscaleImage
    grp3(4).Bitmap.ConvertTo cdrGrayscaleImage
    grp3(2).Bitmap.ConvertTo cdrGrayscaleImage
    grp4(4).Bitmap.ConvertTo cdrGrayscaleImage
    grp4(2).Bitmap.ConvertTo cdrGrayscaleImage
    grp5(4).Bitmap.ConvertTo cdrGrayscaleImage
    grp5(2).Bitmap.ConvertTo cdrGrayscaleImage
End Sub
Sub TemporaryMacro()
    ' Recorded 20.05.2016
    Dim OrigSelection As ShapeRange
    Set OrigSelection = ActiveSelectionRange
    OrigSelection(1).Bitmap.ConvertTo cdrGrayscaleImage
End Sub
Sub randcolorRect()
    ' Recorded 30.06.2016
    Randomize
    Dim s1 As Shape
    Dim s2 As Shape
    Dim s As Integer, m As Integer, y As Integer, k As Integer
    Set s1 = ActiveLayer.CreateRectangle(5, 5, 4, 4)
    s = (100 * Rnd) + 1
    m = (100 * Rnd) + 1
    y = (100 * Rnd) + 1
    k = (100 * Rnd) + 1
    
    Set s2 = ActiveLayer.CreateArtisticTextWide(1, 4, s)
    s1.Fill.UniformColor.CMYKAssign s, m, y, k
    s1.Outline.SetNoOutline
    
    
    
End Sub
Sub tret()
    ' Recorded 01.07.2016
    Dim x As Integer
    Dim s2 As Shape
    ActivePage.Shapes.All.CreateSelection
    x = ActiveSelection.Shapes.Count
    Set s2 = ActiveLayer.CreateArtisticTextWide(1, 4, x)
    ActiveSelection.Move 4.518268, 3.545102
    ActiveLayer.Shapes(1).Move -8.967024, -0.225913
    ActiveLayer.Shapes(2).Move -7.837457, 0.364937
    ActiveLayer.Shapes(3).Move -4.328315, 0.04311
    ActiveLayer.Shapes(4).Move -4.622535, -0.191157
    ActiveDocument.RemoveFromSelection ActiveLayer.Shapes(4), ActiveLayer.Shapes(3), ActiveLayer.Shapes(2), ActiveLayer.Shapes(1)
    ActiveSelection.Move 2.554559, -4.709425
    
    
End Sub
Sub Color_changer()
 Color_changer1.Show

End Sub
Sub tret2()
    ' Recorded 01.07.2016
    Dim x As Double, y As Double, x1 As Double, y1 As Double, y2 As Double, max As Double, max1 As Double
    Dim s2 As Shape
    ActiveDocument.ReferencePoint = cdrCenter
    'ActivePage.Shapes.All.CreateSelection
    x = ActivePage.SizeWidth
    y = ActivePage.SizeHeight
    x1 = 0
    y1 = 0
    y2 = 0
    max = 0
    For Each s2 In ActiveSelection.Shapes
    
        
        
        x1 = x1 + (s2.SizeWidth / 2)
        y1 = y1 + (s2.SizeHeight / 2)
        
        If (x1 + (s2.SizeWidth / 2) > x) Then
        y2 = y2 + max
        max = 0
        y1 = y2 + (s2.SizeHeight / 2)
        x1 = s2.SizeWidth / 2
        End If
        
        s2.SetPosition x1, y1
        
        If (max < s2.SizeHeight) Then
        max = s2.SizeHeight
        End If
        
        x1 = x1 + (s2.SizeWidth / 2)
        y1 = y2
    Next s2

End Sub
Sub Oppe()
    ' Recorded 01.07.2016
    Dim OrigSelection As ShapeRange
    Set OrigSelection = ActiveSelectionRange
    ActiveDocument.ReferencePoint = cdrCenter
    OrigSelection.SetPosition 0#, 0#
End Sub

Sub krest()
    ' Recorded 04.07.2016
    
    Dim s1 As Shape
    Set s1 = ActiveLayer.CreateLineSegment(-0.442394, 8.64674, -0.442394, 8.189681)
    s1.Fill.ApplyNoFill
    s1.Outline.SetProperties 0.007874, OutlineStyles(0), CreateCMYKColor(0, 0, 0, 100), ArrowHeads(0), ArrowHeads(0), cdrFalse, cdrFalse, cdrOutlineButtLineCaps, cdrOutlineMiterLineJoin, 0#, 100, MiterLimit:=5#
    ActiveDocument.ReferencePoint = cdrCenter
    s1.SetSize 0.000016, 0.098425
    
    s1.SetSize 0.000016, 0.19685
    s1.Move 1.505386, 0.245417
   
    s1.Move 0.02902, 0.186374
    s1.Move -0.02902, -0.129528
    
    s1.Move 0.03937, 0#
    
End Sub
Sub krest1()
    ' Recorded 04.07.2016
    ActiveDocument.ReferencePoint = cdrCenter
    Dim xr As Double, yt As Double, xl As Double, yb As Double, x2 As Double, y2 As Double
    Dim sr As New ShapeRange, sel As ShapeRange
    Set sel = ActiveSelectionRange
    
    xl = 0
    yt = 0
    xr = 0
    yb = 0
    
    x2 = MsgBox("Кресты внутрь?", vbYesNo, "Кресты")
    
    If x2 = 6 Then
    xl = 0.03937
    yt = -0.03937
    xr = -0.03937
    yb = 0.03937
    End If
    
    xl = xl + sel.LeftX
    yt = yt + sel.TopY
    xr = xr + sel.RightX
    yb = yb + sel.BottomY
    
    sr.Add ActiveLayer.CreateLineSegment(xl - 0.03937, yt, xl - 0.23622, yt)
    sr.Add ActiveLayer.CreateLineSegment(xl - 0.03937, yb, xl - 0.23622, yb)
    
    sr.Add ActiveLayer.CreateLineSegment(xr + 0.03937, yt, xr + 0.23622, yt)
    sr.Add ActiveLayer.CreateLineSegment(xr + 0.03937, yb, xr + 0.23622, yb)
    
    sr.Add ActiveLayer.CreateLineSegment(xl, yt + 0.03937, xl, yt + 0.23622)
    sr.Add ActiveLayer.CreateLineSegment(xr, yt + 0.03937, xr, yt + 0.23622)
    
    sr.Add ActiveLayer.CreateLineSegment(xl, yb - 0.03937, xl, yb - 0.23622)
    sr.Add ActiveLayer.CreateLineSegment(xr, yb - 0.03937, xr, yb - 0.23622)
    
    sr.SetOutlineProperties 0.007874
    sr.Combine
    
    
End Sub

Sub fvv()
    ' Recorded 04.07.2016
    Dim OrigSelection As ShapeRange
    Set OrigSelection = ActiveSelectionRange
    OrigSelection.CreateSelection
    Dim s1 As Shape
    Set s1 = ActiveSelection.Combine
End Sub

Sub Test()
 Dim sGroup As Shape
 Dim sr As New ShapeRange
 sr.Add ActiveLayer.CreateEllipse2(0, 0, 0.25)
 sr.Add ActiveLayer.CreateLineSegment(-0.5, 0, 0.5, 0)
 sr.Add ActiveLayer.CreateLineSegment(0, -0.5, 0, 0.5)
 sr.SetOutlineProperties 0.03
 Set sGroup = sr.Group
 sGroup.Move ActivePage.SizeWidth / 2, ActivePage.SizeHeight / 2
End Sub
Sub rasklad()
    
    Dim x1, y1, x2, y2, x, y, posx, posy As Double
    Dim PageX, PageY, countX, countY, countTot As Double
    Dim PageX1, PageY1, countX1, countY1, countTot1 As Double
    Dim countX2, countY2, countX2_1, countY2_1, countX1_1, countY1_1, countTot2 As Double
    Dim a, b, c, d, residueX1, residueY1, residueX2, residueY2, CountRX, CountRY, CountRX_0, CountRY_0 As Double
    Dim s2 As Shape
    Dim sel As ShapeRange
    ActiveDocument.ReferencePoint = cdrCenter
    PageX = ActivePage.SizeWidth
    PageY = ActivePage.SizeHeight
    Set sel = ActiveSelectionRange
    posx = 0
    posy = 0
    
    x1 = sel.SizeWidth
    y1 = sel.SizeHeight
    x2 = sel.SizeHeight
    y2 = sel.SizeWidth
    
    countX1 = Fix(PageX / x1)
    countY1 = Fix(PageY / y1)
    
    
    countX2 = Fix(PageX / x2)
    countY2 = Fix(PageY / y2)
    
    
    
    residueX1 = PageX - x1 * countX1
    If residueX1 = PageX Then
    residueX1 = 0
    End If
    residueY1 = PageY - y1 * countY1
    If residueY1 = PageY Then
    residueY1 = 0
    End If
    
    residueX2 = PageX - x2 * countX2
    If residueX2 = PageX Then
    residueX2 = 0
    End If
    residueY2 = PageY - y2 * countY2
    If residueY2 = PageY Then
    residueY2 = 0
    End If
    
    countX1_1 = Fix(residueX1 / y1)
    countY1_1 = Fix(residueY1 / x1)
    
    countX2_1 = Fix(residueX2 / y2)
    countY2_1 = Fix(residueY2 / x2)
    
    countTot1 = countX1 * countY1 + countX1_1 * countY2 + countY1_1 * countX2
    countTot2 = countX2 * countY2 + countX2_1 * countY1 + countY2_1 * countX1
    
    If countTot2 > countTot1 Then
    sel.Rotate 90
    End If
    
    x = sel.SizeWidth
    y = sel.SizeHeight
    
    countX = Fix(PageX / x)
    countY = Fix(PageY / y)
    
    CountRX = Fix((PageX - x * countX) / y)
    CountRY = Fix((PageY - y * countY) / x)
    

    posx = posx + (sel.SizeWidth / 2)
    posy = posy + (sel.SizeHeight / 2)
    sel.SetPosition posx, posy
    
    For c = 1 To countX
    
       
        posx = ActiveSelectionRange.SizeWidth
        posy = ActiveSelectionRange.SizeHeight
        For a = 1 To countY - 1
           ActiveSelectionRange.Duplicate
            
            posx = 0
            
            sel.Move posx, posy
            
            
        Next a
        If c <> countX Then
        ActiveSelectionRange.Duplicate
        ActiveSelectionRange.SetPosition (sel.SizeWidth / 2) + (sel.SizeWidth * c), sel.SizeHeight / 2
        End If
        
    Next c
    
    b = Fix(PageY / x)
    d = Fix(PageX / y)
    If CountRY = 0 Then
    For c = 1 To CountRX
        If c = 1 Then
        ActiveSelectionRange.Duplicate
        ActiveSelectionRange.Rotate 90
        ActiveSelectionRange.SetPosition (x * countX) + sel.SizeWidth / 2, (y * countY) - sel.SizeHeight / 2
        Else
        ActiveSelectionRange.Duplicate
        ActiveSelectionRange.Move sel.SizeWidth, sel.SizeHeight * (b - 1)
        End If
        
        For a = 1 To b - 1
            
            ActiveSelectionRange.Duplicate
            ActiveSelectionRange.Move 0, 0 - sel.SizeHeight
            


        Next a

    Next c
    Else
    For c = 1 To d
        If c = 1 Then
        ActiveSelectionRange.Duplicate
        ActiveSelectionRange.Rotate 90
        ActiveSelectionRange.SetPosition sel.SizeWidth / 2, (y * countY) + sel.SizeHeight / 2
        Else
        ActiveSelectionRange.Duplicate
        ActiveSelectionRange.Move sel.SizeWidth, 0 - (sel.SizeHeight * (CountRY - 1))
        End If
        
        For a = 1 To CountRY - 1
            
            ActiveSelectionRange.Duplicate
            ActiveSelectionRange.Move 0, sel.SizeHeight
            


        Next a

    Next c
    End If
    
'Set s2 = ActiveLayer.CreateArtisticTextWide(-5, -4, CountRX)
'Set s2 = ActiveLayer.CreateArtisticTextWide(-1, -4, CountRX_0)
'Set s2 = ActiveLayer.CreateArtisticTextWide(-5, -5, CountRX_0)
'Set s2 = ActiveLayer.CreateArtisticTextWide(-1, -5, CountRY_0)

'Set s2 = ActiveLayer.CreateArtisticTextWide(-5, -6, countTot1)
'Set s2 = ActiveLayer.CreateArtisticTextWide(-1, -6, countTot2)
End Sub

