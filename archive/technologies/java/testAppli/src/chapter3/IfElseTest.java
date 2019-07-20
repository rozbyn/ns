package chapter3;

/**
 *
 * @author Rozbyn
 */
public class IfElseTest {
	public static void main(String[] args) {
		int x, y, z;
		boolean done = false;
		
		z = 7;
		x = 14;
		y = 90;
		
		if(x < 10)
			if(y > 100){
				if(!done) x = z;
				else y = z;
			} else System.out.println("ERROR");
		else System.out.println("ERROR2");
	}
}
