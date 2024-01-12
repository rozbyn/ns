package chapter4.Finalize;

/**
 *
 * @author Rozbyn
 */
public class FDemo {
	long x;

	public FDemo(long i) {
		x = i;
	}

	protected void finalize() {
		System.out.println("Финализация "+x);
	}
	
	void generator(long i){
		FDemo o = new FDemo(i);
	}
	
	
	
}
