package chapter4.Help;

/**
 *
 * @author Rozbyn
 */
public class HelpDemoClass {
		
	char getUserInput() throws java.io.IOException {
		char choice, ignore;
		choice = (char)System.in.read();
		do {
			ignore = (char) System.in.read();
		} while (ignore != '\n');
		return choice;
	}
	
	
	boolean isValid (char ch){
		return !(ch < '1' | ch > '7' & ch != 'q');
	}
	
	
	void showMenu(){
		System.out.println("Справка: ");
		System.out.println("\t 1: if");
		System.out.println("\t 2: switch");
		System.out.println("\t 3: for");
		System.out.println("\t 4: while");
		System.out.println("\t 5: do-while");
		System.out.println("\t 6: break");
		System.out.println("\t 7: continue\n");
		System.out.print("Выберите (q для выхода): ");
	}
	
	void helpOn (char what){
		switch (what) {
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
}
