package chapter2;

/**
 *
 * @author Rozbyn
 */
public class logicalOpTable {
	public static void main(String[] args) {
		boolean p, q, temp1, temp2;
		
		System.out.println("P\tQ\tAND\tOR\tXOR\tNOT");
		
		p = true; q = true;
		if(p) System.out.print('1');
		if(!p) System.out.print('0');
		System.out.print("\t");
		if(q)System.out.print('1');
		if(!q)System.out.print('0');
		System.out.print("\t");
		temp1 = (p&q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p|q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p^q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (!p);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		System.out.println();
		
		p = true; q = false;
		if(p) System.out.print('1');
		if(!p) System.out.print('0');
		System.out.print("\t");
		if(q)System.out.print('1');
		if(!q)System.out.print('0');
		System.out.print("\t");
		temp1 = (p&q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p|q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p^q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (!p);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		System.out.println();
		
		p = false; q = true;
		if(p) System.out.print('1');
		if(!p) System.out.print('0');
		System.out.print("\t");
		if(q)System.out.print('1');
		if(!q)System.out.print('0');
		System.out.print("\t");
		temp1 = (p&q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p|q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p^q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (!p);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		System.out.println();
		
		p = false; q = false;
		if(p) System.out.print('1');
		if(!p) System.out.print('0');
		System.out.print("\t");
		if(q)System.out.print('1');
		if(!q)System.out.print('0');
		System.out.print("\t");
		temp1 = (p&q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p|q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (p^q);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		temp1 = (!p);
		if(temp1) System.out.print('1');
		if(!temp1) System.out.print('0');
		System.out.print("\t");
		System.out.println();
		
		
	}
}
