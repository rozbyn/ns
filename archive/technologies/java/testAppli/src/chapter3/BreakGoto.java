package chapter3;

/**
 *
 * @author Rozbyn
 */
public class BreakGoto {
	public static void main(String[] args) {
		outer1 : for (int i = 0; i < 10; i++) outer2: {
			System.out.println("������ ��������, i="+i);
			inner1:{
				if(i == 5){
					break outer2;
				}
				inner11:{
					if (i == 7) {
						break inner1;
					}
					System.out.println("������ 11");
				}
				System.out.println("������ 1");
			}
			System.out.println("����� 1 � 2");
			inner2:{
				System.out.println("������ 2");
			}
			System.out.println("����� 2 � 3");
			inner3:{
				System.out.println("������ 3");
			}
			System.out.println("����� ��������");
		}
		System.out.println("����� for");
	}
}
