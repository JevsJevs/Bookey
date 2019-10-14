/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package desktopapp;

    import com.mysql.jdbc.PreparedStatement;
    import java.sql.Connection;
    import java.sql.Date;
    import java.sql.DriverManager;
    import java.sql.ResultSet;
    import java.sql.SQLException;


/**
 *
 * @author aluno
 */
public class Funcoes {
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
    
    public boolean insere(String tabela, String nome,String idade)
    {
        boolean retorno = false;
        try
        {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("Insert into " + tabela + "(nome,idade) values ('" + nome + "'," + idade + ");");
            stmt.execute();
            stmt.close();
            retorno = true ; 
        }
        catch(SQLException ex)
        {
            System.err.print("Erro INSERT: "+ex);
        }
        return retorno;
            
    }
    
    public boolean insereD(String tabela, String nome,Date data)
    {
        boolean retorno = false;
        try
        {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("Insert into " + tabela + "(Nome,Data) values ('" + nome + "','" + data + "');");
            stmt.execute();
            stmt.close();
            retorno = true ; 
        }
        catch(SQLException ex)
        {
            System.err.print("Erro INSERT: "+ex);
        }
        return retorno;  
    }
    
    public ResultSet consulta(String consulta)
    {
        ResultSet rs = null;
        
        try
        {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement(consulta);
            rs = stmt.executeQuery();
        }
        catch(Exception e)
        {
            System.err.println("Erro Consulta"+e );
        }
        
        return rs;
    }
        
    public boolean atualiza(String tabela,String campos,String condicao)
    {
        boolean retorno = false;
        
        try
        {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("update "+tabela+" set "+campos+" where "+condicao);
            stmt.execute();
            stmt.close();
            retorno = true;
        }
        catch(SQLException ex)
        {
            System.err.println("Erro Update: "+ex);
        }
        
        return retorno;
    }
    
    public boolean delete(String tabela,String condicao)
    {
        boolean retorno = false;
        try
        {
            PreparedStatement stmt = (PreparedStatement) this.con.prepareStatement("delete from "+tabela+" where "+condicao);
            stmt.execute();
            stmt.close();
            retorno = true;
        }
        catch(SQLException ex)
        {
            System.err.println("Erro ao apagar: "+ex);
        }
        return retorno;
    }
    
    
}
