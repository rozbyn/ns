package chapter3;

/**
 *
 * @author Rozbyn
 */
public class ForGeometrProgress {
	public static void main(String[] args) {
		for (long i = 2; i < 2000000000; i *= i) {
			System.out.println(i);
		}
	}
}
