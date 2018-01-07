Dim FSO, ghgj, word(27), n, k, j

Set FSO=CreateObject("Scripting.FileSystemObject")

Set ghgj=FSO.CreateTextFile("test.txt")
word(1)="a"
word(2)="b"
word(3)="c"
word(4)="d"
word(5)="e"
word(6)="f"
word(7)="g"
word(8)="h"
word(9)="i"
word(10)="j"
word(11)="k"
word(12)="l"
word(13)="m"
word(14)="n"
word(15)="o"
word(16)="p"
word(17)="q"
word(18)="r"
word(19)="s"
word(20)="t"
word(21)="u"
word(22)="v"
word(23)="w"
word(24)="x"
word(25)="y"
word(26)="z"
	for n=1 to 26
		for k=1 to 26
			for j=1 to 26
					
				ghgj.WriteLine(word(n)+word(k)+word(j)+".ru")
		

			next
	

		next
	

	next
	ghgj.write("asdasddsadasd123eedwdw edf ")
ghgj.close