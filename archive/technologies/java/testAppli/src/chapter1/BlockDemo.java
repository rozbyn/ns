package chapter1;

/**
 *
 * @author Rozbyn
 */
public class BlockDemo {
	public static void main(String[] args) {
		double i, j, d;
		i = 7;
		j = 10;
		
		if(i != 0){
			System.out.println("i не равно нулю");
			d = j / i;
			System.out.println("j / i равно "+d);
			System.out.println(args);
		}
	}
}
