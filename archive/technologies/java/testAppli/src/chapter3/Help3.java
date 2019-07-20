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
				System.out.println("�������: ");
				System.out.println("\t 1: if");
				System.out.println("\t 2: switch");
				System.out.println("\t 3: for");
				System.out.println("\t 4: while");
				System.out.println("\t 5: do-while");
				System.out.println("\t 6: break");
				System.out.println("\t 7: continue\n");
				System.out.println("�������� (q ��� ������): ");
				
				choice = (char)System.in.read();
				
				
				do {
					ignore = (char) System.in.read();
				} while (ignore != '\n');
				
			} while (choice < '1' | choice > '7' & choice != 'q');
			
			if(choice == 'q') break outer;
			System.out.println();
			
			switch (choice) {
				case '1':
					System.out.println("�������� if:");
					System.out.println(" if(�������) ��������;");
					System.out.println(" else ��������;");
					break;
				case '2':
					System.out.println("�������� switch:");
					System.out.println("switch(���������){");
					System.out.println(" case ���������:");
					System.out.println(" ������������������ ����������");
					System.out.println(" break;");
					System.out.println(" //...");
					System.out.println("}");
					break;
				case '3':
					System.out.println("�������� for:");
					System.out.println("for(init; �������; ��������)");
					System.out.println("��������;");
					break;
				case '4':
					System.out.println("�������� while:");
					System.out.println("while(�������) ��������;");
					break;
				case '5':
					System.out.println("�������� do-while:");
					System.out.println("do {");
					System.out.println(" ��������;");
					System.out.println("} while(�������);");
					break;
				case '6':
					System.out.println("�������� break:");
					System.out.println("break; ��� break �����;");
					break;
				case '7':
					System.out.println("�������� continue:");
					System.out.println("continue; ��� continue �����;");
					break;
				default:
					System.out.println("������ �� ������");
					break;
			}
		}
		System.out.println("������� �� ������������� �������");
	}
}
