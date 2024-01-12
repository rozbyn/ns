package chapter5;

/**
 *
 * @author Rozbyn
 */
public class ShowBits {
	int numbits;
	
	public static void main(String[] args) {
		ShowBits.show(984948);
		
	}
	
	
	public static int getBitsCount(long num) {
		double log2 = (Math.log10(num) / Math.log10(2));
		int bitsCount = (int)log2 + 1;
		return bitsCount;
	}
	
	
	public static void show(long val){
		long mask = 1, numbits = getBitsCount(val);
		
		numbits = (int)numbits + (numbits % 4);
		
		mask <<= numbits - 1;
		
		int spacer = 0;
		for (; mask != 0; mask >>>= 1) {
			if((val & mask) != 0) System.out.print("1");
			else System.out.print("0");
			spacer++;
			if(spacer % 4 == 0) {
				System.out.print(" ");
				spacer = 0;
			}
		}
		System.out.println();
	}
}


