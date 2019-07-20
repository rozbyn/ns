package chapter5;

/**
 *
 * @author Rozbyn
 */
public class Buble {
	
	public static void main(String[] args) {
		int[] nums = {4,1,8,3,32,45,11,98,117,-2913};
		System.out.print("Исходный массив: ");
		showArray(nums);
		System.out.println();
		
		sort(nums);
		
		System.out.print("Сортированный массив: ");
		showArray(nums);
		System.out.println();
		
		
	}
	
	public static int[] sort (int[] nums) {
		int t;
		for (int i = 1; i < nums.length; i++) {
			for (int j = nums.length - 1; j >= i; j--) {
				if(nums[j-1] > nums[j]){
					t = nums[j-1];
					nums[j-1] = nums[j];
					nums[j] = t;
				}
			}
		}
		
		return nums;
	}
	
	public static void showArray(int[] arr){
		for (int i = 0; i < arr.length; i++) {
			System.out.print(arr[i] + " ");
		}
	}
}
