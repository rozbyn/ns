package chapter4.Venicle;

public class Venicle {
	int passengers;
	int fuelcap;
	int mpg;
	
	int range(){
		return fuelcap * mpg;
	}
	
	double fuelNeeded(int miles){
		return (double)miles / mpg;
	}
}