package chapter3;

/**
 *
 * @author Rozbyn
 */
public class TestInput1 {
	public static void main(String[] args) throws java.io.IOException {
		int spaceCount = 0;
		outer: for (;;) {
			System.out.println("������� ������: ");
			boolean buffEnded = false;
			char ch = (char) System.in.read();
			System.out.print("�� �����: ");
			do {
				System.out.print(ch);
				if(ch == ' '){
					spaceCount++;
				}
				if(ch == '\n'){
					buffEnded = true;
					System.out.println();
				} else if(ch == '.') {
					break outer;
				} else {
					ch = (char) System.in.read();
				}
			} while (!buffEnded);
		}
		System.out.println("\n��������� ���������, ���������� �������� - "+spaceCount);
	}
}
