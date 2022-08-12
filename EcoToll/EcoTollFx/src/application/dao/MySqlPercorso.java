package application.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import application.model.Percorso;
import application.model.Autostrada;
import application.model.Casello;

/**
 * 
 * class Mysql di Percorso che implementa percorsoDAO
 */

public class MySqlPercorso implements PercorsoDAO{

	private static final String PercorsoDates= "select * from percorso where codicePercorso=?;"; /* PROBLEM */ 
	
	public Percorso getPercorso(String p) {
		
		Percorso percorso = new Percorso();
		
		Connection conn=null;
		PreparedStatement pst=null;
		ResultSet rst=null;		
		conn = MySQLDAOFactory.createConnection();
		try {
			pst=conn.prepareStatement(PercorsoDates);
			pst.setString(1, p);
			rst=pst.executeQuery();
			while (rst.next()){
				 percorso.setCodicePercorso(rst.getInt("codicePercorso"));
				 Autostrada temp = new Autostrada();
				 temp.setName(rst.getString("nomeAutostrada"));
				 //percorso.setAutostrada(temp);
				Casello tempPar = new Casello();
				tempPar.setNome(rst.getString("caselloPartenza"));
				percorso.setCasello1(tempPar);
				Casello tempArr = new Casello();
				tempArr.setNome(rst.getString("caselloArrivo"));
				percorso.setCasello2(tempArr);
				
			}
		}catch (SQLException e)	{
				e.printStackTrace();
		}finally {
			 if (rst != null) { 
				try { rst.close(); } 
			 	catch (SQLException ignore) {}
			 }
			 if (pst != null) {
				try { pst.close(); } 
			 	catch (SQLException ignore) {}
			 }
			 if (conn != null) {
				try { conn.close(); } 
			 	catch (SQLException ignore) {}
			 }
		}
		return percorso;
	}
}
