package chapter1;

/**
 *
 * @author Rozbyn
 */
public class GalToLitTable {
	public static void main(String[] args) {
		double gal, lit;
		
		for (int i = 1; i <= 100; i++) {
			gal = i;
			lit = gal * 3.7854;
			System.out.println(gal + " галлонам соответствует " +
							lit + " литров");
			if(i % 10 == 9){
				System.out.println();
			}
		}
	}
}
