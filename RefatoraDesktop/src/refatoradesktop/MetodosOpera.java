/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package refatoradesktop;

import com.mysql.jdbc.PreparedStatement;
import java.awt.Dimension;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.Toolkit;
import java.awt.image.BufferedImage;
import java.awt.image.RenderedImage;
import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Blob;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.imageio.ImageIO;
import javax.swing.Icon;
import javax.swing.JButton;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;
import javax.swing.ImageIcon;
import javax.swing.JFrame;
import javax.swing.JOptionPane;

/**
 *
 * @author João Eduardo Vasconcellos da Silva
 */
public class MetodosOpera {
    Connection con;
    
    public String formataData(String s)
    {
        String ano = s.substring(0,4);
        String mes = s.substring(5,7);
        String dia = s.substring(8,10);
        
        return dia+"/"+mes+"/"+ano;
    }
    
    public void centraliza(JFrame frame)
    {
        Dimension dim = Toolkit.getDefaultToolkit().getScreenSize();
        frame.setLocation(dim.width/2-frame.getSize().width/2, dim.height/2-frame.getSize().height/2);
    }
    
    public void recuperaImg(String numero, String Hotel,JButton botao)
    {
        int num = Integer.parseInt(numero);
        int htl = Integer.parseInt(Hotel);
        
        try {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT Img FROM Quarto Where codHotel="+htl+" AND nQuarto="+num+" ;");
            ResultSet rs = stmt.executeQuery();
            
            if(rs.next())
            {
                java.sql.Blob blob = rs.getBlob("Img");
                
                InputStream in = blob.getBinaryStream();  
                BufferedImage image = ImageIO.read(in);
                
                ImageIcon icon = ajustaDim(botao,image);
                
                botao.setIcon(icon);
            }
            
            
        } catch (SQLException ex) {
            System.err.println("Erro no SQL amigão: "+ex);
        } catch (IOException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }
    
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
            System.out.println(email);
            
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT idHotel FROM Hotel WHERE email= '"+email+"' ;");
            ResultSet rs = stmt.executeQuery();
            
            rs.next();
            
            retorno =  rs.getInt("idHotel");
        } catch (SQLException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        return retorno;
    }
    
    public void PoeTabela(DefaultTableModel modelo,JTable estrutura,Integer codHotel)
    {
        int linha = 0;
        modelo.setRowCount(0);
        
        try{
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT * FROM Quarto WHERE codHotel="+codHotel);
            ResultSet resultado = stmt.executeQuery();
            
            while(resultado.next())
            {
                modelo.addRow(new String[estrutura.getColumnCount()]);
                
                estrutura.setValueAt(resultado.getInt("codUser"),linha,0);
                estrutura.setValueAt(resultado.getInt("nQuarto"),linha,1);
                
                if(resultado.getDate("checkIn") != null)
                    estrutura.setValueAt(this.formataData(resultado.getDate("checkIn").toString()),linha,2);
                else
                     estrutura.setValueAt("",linha,2);
                
                if(resultado.getDate("checkOut") != null)
                    estrutura.setValueAt(this.formataData(resultado.getDate("checkOut").toString()),linha,3);
                else
                     estrutura.setValueAt("",linha,3);

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
    
    public void finalreserva(int nqto, int codH)
    {
        try {
            System.out.print("Entrei aqui ó"+codH+" - "+nqto);
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("UPDATE Quarto SET codUser=NULL,checkOut=NULL,checkIn=NULL,valTot=NULL WHERE codHotel="+codH+" AND nQuarto="+nqto+" ;");
            
            stmt.execute();
            
        } catch (SQLException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
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
            // com amor Jevs <3
            
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
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        } catch (NoSuchAlgorithmException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        System.out.println(retorno);
        return retorno;
    }
    
    public void carregaImg(JButton but,String arq)
    {
        try{
            File f;
            f = new File(arq);
            BufferedImage bf = ImageIO.read(f);
            
            Image ajustada = bf.getScaledInstance(but.getWidth(),but.getHeight(),1);
            ImageIcon icon = new ImageIcon(ajustada);
            
            
            
            but.setIcon(icon);
        }catch(Exception e)
        {
            System.err.print(e);
        }
        
    }
    
    public ImageIcon ajustaDim(JButton but, BufferedImage img)
    {
        Image ajustada = img.getScaledInstance(but.getWidth(),but.getHeight(),1);
        ImageIcon icon = new ImageIcon(ajustada);
        
        return icon;
    }
    
    public void apagarQuarto(int numeroQto,int nHotel)
    {
        try {
            
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("DELETE FROM Quarto WHERE nQuarto="+numeroQto+" AND codHotel="+nHotel+";"); 
            stmt.execute();
            
        } catch (SQLException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            System.err.print("Erro ao excluir");
        }
        
    }
    
    public void editarQuarto(Float valdia,int hotel, int qto,String caminho) // implementar imgagem
    {
        

            try {
                java.sql.PreparedStatement stmt;
                stmt = (java.sql.PreparedStatement) this.con.prepareStatement("UPDATE Quarto SET valDiaria=?,Img=? WHERE codHotel=? AND nQuarto=? ;");
                stmt.setFloat(1,valdia);
                
                File f = new File(caminho);
                                
                FileInputStream entra;
                entra = new FileInputStream(f);
                
                stmt.setBinaryStream(2,entra,(int) f.length());
                                
                stmt.setInt(3,hotel);
                stmt.setInt(4,qto);

                stmt.execute();
                stmt.close();
            } catch (SQLException ex) {
                Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
                Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            }
 
    }
        
    public boolean verifyNumqto(int numero,int hotel)
    {
        try {
            boolean retorno = false;
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT * FROM Quarto WHERE codHotel="+hotel+" AND nQuarto="+numero+";");
            ResultSet rs = stmt.executeQuery();

            if(rs.next())
            {
                retorno = true;
            }
            
            return retorno;
            
        } catch (SQLException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

    public void cadastraQuarto(String num, String valdiaria,String caminho,int codhotel) //agregar o codHotel 
    {
        try {
                java.sql.PreparedStatement stmt;
                stmt = (java.sql.PreparedStatement) this.con.prepareStatement("INSERT INTO Quarto(codHotel,nQuarto,valDiaria,Img) VALUES (?,?,?,?) ;");
                stmt.setInt(1,codhotel);
                stmt.setInt(2,Integer.parseInt( num ) );
                stmt.setFloat(3, Float.parseFloat( valdiaria) );
                
                File f = new File(caminho);
                                
                FileInputStream entra;
                entra = new FileInputStream(f);
                
                stmt.setBinaryStream(4,entra,(int) f.length());
                
                stmt.execute();
                stmt.close();
                
            } catch (SQLException ex) {
                Logger.getLogger(Logado.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            }
    }
}
