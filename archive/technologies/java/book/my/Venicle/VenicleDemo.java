
public class VenicleDemo {
	public static void main(String[] args) {
		Venicle minivan = new Venicle();
		int range;
		
		minivan.passengers = 7;
		minivan.fuelcap = 16;
		minivan.mpg = 21;
		
		range = minivan.fuelcap * minivan.mpg;
		
		System.out.println("����-������ ����� ��������� "+minivan.passengers+" ���������� �� ���������� "+range+" ����");
	}
}