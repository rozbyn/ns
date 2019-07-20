package chapter2;

/**
 *
 * @author Rozbyn
 */
public class simpleNumbers {
	public static void main(String[] args) {
		int start = 2, end = 100;
		
		
		System.out.println("Простые числа: ");
		
		
		
		for (int i = start; i <= end; i++) {
			boolean isSimple = true;
			for (int j = start; j < end; j++) {
				if((i > j) && (i != j) && (i % j == 0)){
					isSimple = false;
				}
			}
			if(isSimple){
				System.out.println("Число " + i + " простое");
			}
		}
		
		
	}
}
