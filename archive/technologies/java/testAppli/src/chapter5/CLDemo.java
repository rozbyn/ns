package chapter5;

/**
 *
 * @author Rozbyn
 */
public class CLDemo {
	public static void main(String[] args) {
		System.out.println("��������� �������� "+args.length + " ���������� ��������� ������.");
		if(args.length <= 0){
			return;
		}
		System.out.println("������ ����������: ");
		for (int i = 0; i < args.length; i++) {
			System.out.println("args["+i+"] = "+args[i]);
		}
	}
}
