package chapter4.Finalize;

/**
 *
 * @author Rozbyn
 */
public class Finalize {
	public static void main(String[] args) {
		FDemo ob = new FDemo(0);
		
		for (long i = 0; i < 1000000000; i++) {
			ob.generator(i);
		}
	}
	
	double myMeth (int a, int b){
		return a/b;
	}
}
