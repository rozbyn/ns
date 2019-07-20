package chapter3;

/**
 *
 * @author Rozbyn
 */
public class Help3 {
	public static void main(String[] args) throws java.io.IOException {
		char choice, ignore;
		outer: for (;;) {
			do {
				System.out.println("Справка: ");
				System.out.println("\t 1: if");
				System.out.println("\t 2: switch");
				System.out.println("\t 3: for");
				System.out.println("\t 4: while");
				System.out.println("\t 5: do-while");
				System.out.println("\t 6: break");
				System.out.println("\t 7: continue\n");
				System.out.println("Выберите (q для выхода): ");
				
				choice = (char)System.in.read();
				
				
				do {
					ignore = (char) System.in.read();
				} while (ignore != '\n');
				
			} while (choice < '1' | choice > '7' & choice != 'q');
			
			if(choice == 'q') break outer;
			System.out.println();
			
			switch (choice) {
				case '1':
					System.out.println("Оператор if:");
					System.out.println(" if(условие) оператор;");
					System.out.println(" else оператор;");
					break;
				case '2':
					System.out.println("Оператор switch:");
					System.out.println("switch(выражение){");
					System.out.println(" case константа:");
					System.out.println(" последовательность операторов");
					System.out.println(" break;");
					System.out.println(" //...");
					System.out.println("}");
					break;
				case '3':
					System.out.println("Оператор for:");
					System.out.println("for(init; условие; итерация)");
					System.out.println("оператор;");
					break;
				case '4':
					System.out.println("Оператор while:");
					System.out.println("while(условие) оператор;");
					break;
				case '5':
					System.out.println("Оператор do-while:");
					System.out.println("do {");
					System.out.println(" оператор;");
					System.out.println("} while(условие);");
					break;
				case '6':
					System.out.println("Оператор break:");
					System.out.println("break; или break метка;");
					break;
				case '7':
					System.out.println("Оператор continue:");
					System.out.println("continue; или continue метка;");
					break;
				default:
					System.out.println("Запрос не найден");
					break;
			}
		}
		System.out.println("Списибо за использование справки");
	}
}
