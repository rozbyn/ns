package chapter3;

/**
 *
 * @author Rozbyn
 */
public class TestInput {
	public static void main(String[] args) throws java.io.IOException {
		
		for (int i = 0; i < 5; i++) {
			System.out.println("Введите строку: ");
			boolean buffEnded = false;
			char ch = (char) System.in.read();
			System.out.print("Вы ввели: ");
			do {
				System.out.print(ch);
				if(ch == '\n'){
					buffEnded = true;
					System.out.println();
				} else {
					ch = (char) System.in.read();
				}
			} while (!buffEnded);
		}
	}
}
