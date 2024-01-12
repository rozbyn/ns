package chapter3;

/**
 *
 * @author Rozbyn
 */
public class KbIn {
	public static void main(String[] args)
	throws java.io.IOException {
		char ch;
		
		System.out.println("Нажмите нужную клавишу, а затем клавишу ENTER");
		
//		ch = (char) System.in.read();
		
		System.out.println(System.in.read());
	}
}
