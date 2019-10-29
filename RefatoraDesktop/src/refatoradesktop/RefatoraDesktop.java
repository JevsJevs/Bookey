/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package refatoradesktop;

import java.awt.Dimension;
import java.awt.Toolkit;

/**
 *
 * @author João
 */
public class RefatoraDesktop {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Login l = new Login();
        
        Dimension dim = Toolkit.getDefaultToolkit().getScreenSize();
        l.setLocation(dim.width/2-l.getSize().width/2, dim.height/2-l.getSize().height/2);
        
        l.setVisible(true);
    }
    
}
