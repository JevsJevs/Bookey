/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package desktopapp;

import com.mysql.jdbc.PreparedStatement;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.imageio.ImageIO;
import javax.swing.JButton;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;
import javax.swing.ImageIcon;

/**
 *
 * @author aluno
 */
public class MétodosOpera {
    Connection con;
    
    public boolean conecta(String local, String banco, String usuario, String senha)
    {
        boolean retorno = false;
        
        try{
            Class.forName("com.mysql.jdbc.Driver");
            con = DriverManager.getConnection("jdbc:mysql://"+local+"/"+banco,usuario,senha);
            retorno = true;
        }
        catch(ClassNotFoundException | SQLException e)
        {
            System.err.println("Erro de Conexão:\n"+e);
        }
        return retorno;
    }
    
    public int numeroHotel(String email)
    {
        int retorno = -1;
        try {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT codHotel FROM `Hotel` WHERE email="+email+";");
            ResultSet rs = stmt.executeQuery();
            
            rs.next();
            
            retorno =  rs.getInt("codHotel");

        } catch (SQLException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        return retorno;
    }
    
    public void PoeTabela(DefaultTableModel modelo,JTable estrutura,Integer codHotel)
    {
        int linha = 0;
        modelo.setRowCount(0);
        System.out.println("SELECT * FROM Quarto WHERE codHotel=23");
                
        try{
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT * FROM Quarto WHERE codHotel=23");
            ResultSet resultado = stmt.executeQuery();
            
            if (resultado.next())
                System.out.println("SELECT * FROM Quarto WHERE codHotel=23");

            while(resultado.next())
            {
                modelo.addRow(new String[estrutura.getColumnCount()]);
                
                estrutura.setValueAt(resultado.getInt("codUser"),linha,0);
                estrutura.setValueAt(resultado.getInt("nQuarto"),linha,1);
                estrutura.setValueAt(resultado.getDate("checkIn"),linha,2);
                estrutura.setValueAt(resultado.getDate("checkOut"),linha,3);
                estrutura.setValueAt(resultado.getFloat("valDiaria"),linha,4);
                estrutura.setValueAt(resultado.getFloat("valTot"),linha,5);
                linha++;
            }
            
        }
        catch(SQLException e)
        {
            System.err.println(e);
        }   
    }
        
    public boolean senhacorr(String senha,String email)
    {
        boolean retorno = false;

        try {            
            MessageDigest md = MessageDigest.getInstance("MD5");

            BigInteger hash = new BigInteger(1, md.digest(senha.getBytes()));
            System.out.println("Senha digitada: "+hash.toString(16)+"\n");
            String cryptS = hash.toString(16);
            
            
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT senha FROM Hotel WHERE email='"+email+"' ;");
            ResultSet rs = stmt.executeQuery();
            String verfSenha = "";
                        
            if(rs.next())
            {
                verfSenha = rs.getString("senha");
            }
            
            if(verfSenha.equals(cryptS))
            {
                retorno = true;      
            }
      
        } catch (SQLException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        } catch (NoSuchAlgorithmException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        System.out.println(retorno);
        return retorno;
    }
    
    public void carregaImg(JButton but,String arq)
    {
        try{
            /*Image img = ImageIO.read(getClass().getResource(arq));
            System.out.println("entrou: "+arq);
            but.setIcon(new ImageIcon(img));*/
            File f;
            f = new File(arq);
            BufferedImage bf = ImageIO.read(f);
            ImageIcon icon = new ImageIcon(bf);
            but.setIcon(icon);
        }catch(Exception e)
        {
            System.err.print(e);
        }
        
    }
    
    public void apagarQuarto(Integer numeroQto,Integer nHotel)
    {
        try {
            
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("DELETE FROM Quartos WHERE nQuarto="+numeroQto+" AND codHotel="+nHotel+";"); 
            stmt.executeQuery();
            
        } catch (SQLException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            System.err.print("Erro ao excluir");
        }
        
    }
    
    public void editarQuarto(Integer valtot,Integer valdia,Integer hotel, Integer qto) // implementar imgagem
    {
        if((valtot == null) || (valdia == null) || (valtot == 0) || (valdia == 0))
            System.err.print("Calma lá, preencha todos os campos");
        else
        {
            
            try {
                PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("UPDATE Quarto SET valDiaria="+valdia+", valTot="+valtot+" WHERE codHotel="+hotel+" AND nQuarto"+qto+";");
                stmt.execute();
            } catch (SQLException ex) {
                Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            }
        } 
           
    }
    
    public void novoQuarto(Integer Valdia,JButton botao, Integer num) //imagem
    {
           try {
            // TODO add your handling code here:
            
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("INSERT INTO Quarto (nQuarto, valDiaria, Img) VALUES (?,?,?)"); // falta imagem
            stmt.setInt(1,num);
            stmt.setFloat(2,Valdia);
            
            //imagem
            
            stmt.execute();
            
        } catch (SQLException ex) {
            Logger.getLogger(Logado.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public boolean verifyNumqto(Integer numero,Integer hotel)
    {
        try {
            boolean retorno = false;
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT * FROM Quarto WHERE codHotel="+hotel+" AND nQuarto="+numero+";");
            ResultSet rs = stmt.executeQuery();
            
            if(!rs.next())
            {
                retorno = true;
            }
            
            return retorno;
            
        } catch (SQLException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }
}
