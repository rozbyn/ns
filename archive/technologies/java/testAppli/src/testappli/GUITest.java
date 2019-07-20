package testappli;


import javax.swing.*;
/**
 *
 * @author Rozbyn
 */
public class GUITest {
	GUITest(){
		JFrame jfrm = new JFrame("A simple SWING Application");
		jfrm.setSize(275,100);
		jfrm.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		JLabel jlab = new JLabel("Swing defines the moderm Java GUI");
		
		jfrm.add(jlab);
		
		jfrm.setVisible(true);
	}
	
	
	public static void main(String[] args) {
		SwingUtilities.invokeLater(new Runnable(){
			public void run(){
				new GUITest();
			}
		});
	}
}
