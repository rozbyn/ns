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
		System.out.println("�������: ");
		System.out.println("\t 1: if");
		System.out.println("\t 2: switch");
		System.out.println("\t 3: for");
		System.out.println("\t 4: while");
		System.out.println("\t 5: do-while");
		System.out.println("\t 6: break");
		System.out.println("\t 7: continue\n");
		System.out.print("�������� (q ��� ������): ");
	}
	
	void helpOn (char what){
		switch (what) {
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
}
