package chapter4.Help;

/**
 *
 * @author Rozbyn
 */
public class Help {
	public static void main(String[] args) throws java.io.IOException {
		char choise;
		
		HelpDemoClass helpObj = new HelpDemoClass();
		
		for (;;) {
			helpObj.showMenu();
			choise = helpObj.getUserInput();
			
			if(!helpObj.isValid(choise)) continue;
			
			if(choise == 'q') break;
			
			helpObj.helpOn(choise);
			
		}
		
		System.out.println("Списибо за использование справки");
		
	}
}
