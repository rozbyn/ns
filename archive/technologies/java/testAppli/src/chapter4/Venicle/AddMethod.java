package chapter4.Venicle;

public class AddMethod {
	public static void main(String[] args) {
		Venicle minivan = new Venicle();
		Venicle sportscar = new Venicle();
		
		minivan.passengers = 7;
		minivan.fuelcap = 16;
		minivan.mpg = 21;
		
		sportscar.passengers = 2;
		sportscar.fuelcap = 14;
		sportscar.mpg = 12;
		
		
		System.out.print("����-������ ����� ��������� "+minivan.passengers+" ����������. ");
		minivan.range();
		
		System.out.print("���������� ���������� ����� ��������� "+sportscar.passengers+" ����������. ");
		sportscar.range();
		
	}
}