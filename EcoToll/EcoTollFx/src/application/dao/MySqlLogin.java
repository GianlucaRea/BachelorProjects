package application.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import application.model.Amministratore;

/**
 * 
 * class Mysql di login che implementa loginDAO
 */

public class MySqlLogin implements LoginDAO{
	
	private static final String Login = "select * from ecotolldatabase.amministratore where username = ? and password = ?";
	

	public boolean getAmministratore(String username, String password) {
		
		Amministratore admin = new Amministratore();
		boolean bool = false;	
        Connection conn = null;
        PreparedStatement pst = null;
        ResultSet rst = null;
        
        
        
        try {
        	conn = MySQLDAOFactory.createConnection();
        	pst = conn.prepareStatement(Login);
            pst.setString(1, username);
            pst.setString(2, password);
            rst=pst.executeQuery();

            while (rst.next()){
            	admin.setUsername(rst.getString("username"));
				admin.setPassword(rst.getString("password"));
				bool = true;
			}
        	} catch (SQLException e) {
                e.printStackTrace();
            } finally {
                 if (rst != null) { 
    		try { rst.close(); } 
    		catch (SQLException ignore) {}
                 }
                try {
                    pst.close();
                } catch (Exception sse) {
                    sse.printStackTrace();
                }
                try {
                    conn.close();
                } catch (Exception cse) {
                    cse.printStackTrace();
                }
            }
        System.out.println();
        return bool;
	}
}
