package chapter3;

/**
 *
 * @author Rozbyn
 */
public class BreakGoto {
	public static void main(String[] args) {
		outer1 : for (int i = 0; i < 10; i++) outer2: {
			System.out.println("начало итерации, i="+i);
			inner1:{
				if(i == 5){
					break outer2;
				}
				inner11:{
					if (i == 7) {
						break inner1;
					}
					System.out.println("внутри 11");
				}
				System.out.println("внутри 1");
			}
			System.out.println("между 1 и 2");
			inner2:{
				System.out.println("внутри 2");
			}
			System.out.println("между 2 и 3");
			inner3:{
				System.out.println("внутри 3");
			}
			System.out.println("конец итерации");
		}
		System.out.println("После for");
	}
}
