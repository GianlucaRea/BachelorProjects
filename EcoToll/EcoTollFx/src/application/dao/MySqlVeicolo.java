package application.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import application.model.Veicolo;

/**
 * 
 * class Mysql di Veicolo che implementa VeicoloDAO
 */

public class MySqlVeicolo implements VeicoloDAO{

	private static final String VeicoloDates= "select * from veicolo where targa=?;";
	private static final String addVeicolo ="insert into ecotolldatabase.veicolo value (?,?,?,?,?,?,?,?)";
	private static final String selectAllVeicolo = "select targa from ecotolldatabase.veicolo order by nome;";
	private static final String deleteVeicolo = "delete from ecotolldatabase.veicolo where targa=?;";
	
	public Veicolo getVeicolo(String targa) {
		
		Veicolo veicolo = new Veicolo();
		
		Connection conn=null;
		PreparedStatement pst=null;
		ResultSet rst=null;		
		conn = MySQLDAOFactory.createConnection();
		try {
			pst=conn.prepareStatement(VeicoloDates);
			pst.setString(1, targa);
			rst=pst.executeQuery();
			while (rst.next()){
				veicolo.setTarga(rst.getString("targa"));
				veicolo.setModello(rst.getString("modello"));
				veicolo.setMarca(rst.getString("marca"));
				veicolo.setPeso(rst.getInt("peso"));
				veicolo.setNumeroAssi(rst.getInt("n°assi"));
				veicolo.setClasseEuro(rst.getInt("classeEuro"));
				veicolo.setAnno(rst.getInt("anno"));
				veicolo.setAltezza(rst.getDouble("altezza"));
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
		return veicolo;
	}

	public boolean insertVeicolo(Veicolo toAdd) {
		Connection conn=null;
		PreparedStatement pst=null;
		
		conn = MySQLDAOFactory.createConnection();
		try {
			pst = conn.prepareStatement(addVeicolo);
			pst.setString(1, toAdd.getTarga());		
			pst.setString(2, toAdd.getModello());
			pst.setString(3, toAdd.getMarca());
			pst.setInt(4, toAdd.getPeso());
			pst.setInt(5, toAdd.getNumeroAssi());
			pst.setInt(6, toAdd.getClasseEuro());
			pst.setInt(7, toAdd.getAnno());
			pst.setDouble(8, toAdd.getAltezza());
			int i = pst.executeUpdate();
			if (i==1) {return true;}
			else return false;
		} catch (SQLException e) {
			e.printStackTrace();
			return false;
		} finally {
			 if (pst != null) { 
				 try { pst.close(); } 
				 catch (SQLException ignore) {}
			 }
			 if (conn != null) {
				 try { conn.close(); } 
			 catch (SQLException ignore) {}
			 }
		}
	}

	@Override
	public boolean deleteVeicolo(Veicolo toDelete) {
		Connection conn=null;
		PreparedStatement pst=null;
				
		conn = MySQLDAOFactory.createConnection();
		try {
		pst = conn.prepareStatement(deleteVeicolo);
		pst.setString(1, toDelete.getTarga());
		int i = pst.executeUpdate();
		if (i==1) return true;
		else return false;
		}catch (SQLException e)	{
			e.printStackTrace();
			return false;
		}finally {
			 if (pst != null) { 
				 try { pst.close(); } 
				 catch (SQLException ignore) {}
				 }
			 if (conn != null) {
				 try { conn.close(); } 
			 catch (SQLException ignore) {}
			 }
		}
	}

	@Override
	public List<Veicolo> getAllVeicolo() {
		List<Veicolo> listOfVeicolo = new ArrayList<>();
		
		Connection conn=null;
		PreparedStatement pst=null;
		ResultSet rst=null;
		
		conn = MySQLDAOFactory.createConnection();
		
		try {
			pst = conn.prepareStatement(selectAllVeicolo);
			rst = pst.executeQuery();
			while (rst.next()) {
				String temp = rst.getString("targa");
				Veicolo v = getVeicolo(temp);
				listOfVeicolo.add(v);	
			}
		}
		catch (SQLException e) {
				e.printStackTrace();
			}
		finally {
			 if (pst != null) { 
				 try { pst.close(); } 
				 catch (SQLException ignore) {}
				 }
			 if (conn != null) {
				 try { conn.close(); } 
			 catch (SQLException ignore) {}
			 }
		}
		return listOfVeicolo;
	}
}