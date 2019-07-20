package chapter5;

/**
 *
 * @author Rozbyn
 */
public class QDemo {
	public static void main(String[] args) {
		Queue bigQ = new Queue(100);
		Queue smallQ = new Queue(4);
		
		char ch;
		int i;
		
		System.out.println("Использование очереди bigQ для сохранения алфавита");
		for (i = 0; i < 26; i++) {
			bigQ.put((char)('A'+i));
		}
		System.out.println("Содержимое очереди bigQ: ");
		for (i = 0; i < 48; i++) {
			ch = bigQ.get();
			if(ch != (char)0) System.out.print(ch);
			else break;
		}
		System.out.println();
		
		System.out.println("Использование очереди smallQ для генерации ошибок");
		for (i = 0; i < 10; i++) {
			System.out.print("Попытка сохранения "+(char)('Z'-i));
			smallQ.put((char)('Z'-i));
			
			System.out.println();
		}
		
		for (i = 0; i < 10; i++) {
			System.out.print("Содержимое smallQ: ");
			ch = smallQ.get();
			if (ch != (char) 0) {
				System.out.print(ch);
			}
			System.out.println();
		}
		
		
		
	}
}









class Queue{
	char[] q;
	int putLoc, getLoc;

	public Queue(int size) {
		q = new char[size+1];
		putLoc = getLoc = 0;
	}
	
	void put (char ch){
		if(putLoc == q.length-1){
			System.out.println(" - Очередь заполнена");
			return;
		}
		
		putLoc++;
		q[putLoc] = ch;
	}
	
	char get () {
		if(getLoc == putLoc){
			System.out.println(" - Очередь пуста");
			return (char) 0;
		}
		
		getLoc++;
		return q[getLoc];
	}
}

