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
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
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
 * @author aluno
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
                ImageIcon Icon = new ImageIcon(blob.getBytes(1,(int) blob.length() ) );
                botao.setIcon(Icon);
            }
            
            
        } catch (SQLException ex) {
            System.err.println("Erro no SQL amigão: "+ex);
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
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("SELECT * FROM Quarto WHERE codHotel=23");
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
    
    public void editarQuarto(Float valdia,int hotel, int qto,JButton but) // implementar imgagem
    {
        

            try {
                java.sql.PreparedStatement stmt;
                stmt = (java.sql.PreparedStatement) this.con.prepareStatement("UPDATE Quarto SET valDiaria=?,Img=? WHERE codHotel=? AND nQuarto=? ;");
                stmt.setFloat(1,valdia);
                
                /*
                ---------------------------------------------------------
                BufferedImage buffered= this.IconBuf(but);
                
                ByteArrayOutputStream baos = new ByteArrayOutputStream();
                ImageIO.write(buffered, "png", baos );
                byte[] imageInByte = baos.toByteArray();

                Blob blob = con.createBlob();
                blob.setBytes(4, imageInByte);
                
                
                
                ---------------------------------------------------------
                */
                
                
                //File nf = File.createTempFile("imgTemp.png",null);

                File nf = new File("imgTemp.png");
                nf.createNewFile();
                BufferedImage bi;
                bi = this.IconBuf(but);
                
                /* Graphics2D bImageGraphics = bi.createGraphics();
                
                RenderedImage rImage = (RenderedImage) bi ;*/

                if(ImageIO.write(bi, "png", nf))
                {
                    System.out.println("Sucesso para gravar imagem");
                }
                
                FileInputStream entra;
                entra = new FileInputStream(nf);
                
                stmt.setBinaryStream(2,entra,(int) nf.length());
                
                // A imagem nao esta sendo enviada - arquivo vazio;
                
                // ---------------------------------------------------------
                
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
    
    public BufferedImage IconBuf(JButton bt)
    {
        BufferedImage retorno;
        
        Icon icon = bt.getIcon();
        
        retorno = new BufferedImage(icon.getIconWidth(),icon.getIconHeight(),BufferedImage.TYPE_INT_RGB);
        
        return retorno;
    }
    
    public void cadastraQuarto(String num, String valdiaria, JButton but,int codhotel) //agregar o codHotel 
    {
        try {
                java.sql.PreparedStatement stmt;
                stmt = (java.sql.PreparedStatement) this.con.prepareStatement("INSERT INTO Quarto(codHotel,nQuarto,valDiaria,Img) VALUES (?,?,?,?) ;");
                stmt.setInt(1,codhotel);
                stmt.setInt(2,Integer.parseInt( num ) );
                stmt.setFloat(3, Float.parseFloat( valdiaria) );
                
                /*
                ---------------------------------------------------------
                BufferedImage buffered= this.IconBuf(but);
                
                ByteArrayOutputStream baos = new ByteArrayOutputStream();
                ImageIO.write(buffered, "png", baos );
                byte[] imageInByte = baos.toByteArray();

                Blob blob = con.createBlob();
                blob.setBytes(4, imageInByte);
                
                
                
                ---------------------------------------------------------
                */
                                

                //File nf = File.createTempFile("imgTemp.png",null);

                File nf = new File("imgTemp.png");
                nf.createNewFile();
                BufferedImage bi;
                bi = this.IconBuf(but);
                
               /* Graphics2D bImageGraphics = bi.createGraphics();
                
                RenderedImage rImage = (RenderedImage) bi ;*/

                if(ImageIO.write(bi, "png", nf))
                {
                    System.out.println("Sucesso para gravar imagem");
                }
                
                FileInputStream entra;
                entra = new FileInputStream(nf);
                
                stmt.setBinaryStream(4,entra,(int) nf.length());
                
                // A imagem nao esta sendo enviada - arquivo vazio;
                
               // ---------------------------------------------------------
                
                
                stmt.execute();
                stmt.close();
                
            } catch (SQLException ex) {
                Logger.getLogger(Logado.class.getName()).log(Level.SEVERE, null, ex);
            } catch (FileNotFoundException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
            Logger.getLogger(MetodosOpera.class.getName()).log(Level.SEVERE, null, ex);
            }
    }
}
