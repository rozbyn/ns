package chapter5;

/**
 *
 * @author Rozbyn
 */
public class CLDemo {
	public static void main(String[] args) {
		System.out.println("Программе передано "+args.length + " аргументов командной строки.");
		if(args.length <= 0){
			return;
		}
		System.out.println("Список аргументов: ");
		for (int i = 0; i < args.length; i++) {
			System.out.println("args["+i+"] = "+args[i]);
		}
	}
}
