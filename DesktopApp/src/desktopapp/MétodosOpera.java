/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package desktopapp;

import com.mysql.jdbc.PreparedStatement;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;

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
    
    public void PoeTabela(DefaultTableModel modelo,JTable estrutura,Integer codHotel)
    {
        int linha = 0;
        modelo.setRowCount(0);
        try{
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT * FROM `Quarto` WHERE codHotel="+codHotel+";");

            ResultSet resultado = stmt.executeQuery();

            while(resultado.next())
            {
                modelo.addRow(new String[estrutura.getColumnCount()]);
                estrutura.setValueAt(resultado.getString("IdUser"),linha,0);
                estrutura.setValueAt(resultado.getInt("Numero Quarto"),linha,1);
                estrutura.setValueAt(resultado.getInt("Check In"),linha,2);
                estrutura.setValueAt(resultado.getInt("Check Out"),linha,3);
                estrutura.setValueAt(resultado.getInt("Diária"),linha,4);
                estrutura.setValueAt(resultado.getInt("Cobrança total"),linha,5);
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
            byte[] valores = senha.getBytes();
            MessageDigest md = MessageDigest.getInstance("MD5");
            md.update(valores);
            byte[] hashMd5 = md.digest();
        
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT senha FROM Hotel WHERE email="+email+" ;");
            ResultSet rs = stmt.executeQuery();
            String verfSenha = "";
            if(rs.next())
            {
                verfSenha = rs.getString("senha");
            }
            
            String cryptS = new String(hashMd5);
            
            if(verfSenha.equals(cryptS))
            {
                retorno = true;
            }
      
        } catch (SQLException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        } catch (NoSuchAlgorithmException ex) {
            Logger.getLogger(MétodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        return retorno;
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
    
    public void novoQuarto(Integer Valdia) //imagem
    {
        if((Valdia==null) || (Valdia==0))
        {
            
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
    }
}
