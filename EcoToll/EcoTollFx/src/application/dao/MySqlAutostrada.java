package application.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import application.model.Autostrada;

/**
 * 
 * class Mysql di autostrada che implementa AutostradaDAO
 */
public class MySqlAutostrada implements AutostradaDAO{

	private static final String selectAllAutostrada = "select nome from ecotolldatabase.autostrada order by nome";
	private static final String deleteAutostrada = "delete from ecotolldatabase.autostrada where nome=?";
	private static final String addAutostrada ="insert into ecotolldatabase.autostrada value (?)";
	private static final String addTariffa ="insert into ecotolldatabase.tariffa(?,?,?)";
	private static final String deleteTariffa ="delete from ecotolldatabase.tariffa where nomeAutostrada=? and classeVeicolo=?";
	private static final String updateNome ="update ecotolldatabase.autostrada set nome =? where nome=?";
	private static final String getTariffa="select valore from ecotolldatabase.tariffa where nomeAutostrada=? and classeVeicolo=?";
	
	public List<Autostrada> getListOfAutostrada() {
		
		List<Autostrada> listOfAutostrada = new ArrayList<>();
		
		Connection conn=null;
		PreparedStatement pst=null;
		ResultSet rst=null;
		
		conn = MySQLDAOFactory.createConnection();
		
		try {
			pst = conn.prepareStatement(selectAllAutostrada);
			rst = pst.executeQuery();
			while (rst.next()) {
				Autostrada a = new Autostrada();
				a.setName(rst.getString("nome"));;
				listOfAutostrada.add(a);
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
		return listOfAutostrada;
	}
	
	public boolean deleteAutostrada(Autostrada toDelete) {
		
		Connection conn=null;
		PreparedStatement pst=null;
				
		conn = MySQLDAOFactory.createConnection();
		try {
		pst = conn.prepareStatement(deleteAutostrada);
		pst.setString(1, toDelete.getNome());
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
	
	public boolean addAutostrada(Autostrada toAdd) {
		
		Connection conn=null;
		PreparedStatement pst=null;
		
		conn = MySQLDAOFactory.createConnection();
		try {
			pst = conn.prepareStatement(addAutostrada);
			pst.setString(1, toAdd.getNome());	
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
	
	public boolean addTariffa(Autostrada toAdd, int classe, double value) {
		
		Connection conn=null;
		PreparedStatement pst=null;
		
		conn = MySQLDAOFactory.createConnection();
		try {
			pst = conn.prepareStatement(addTariffa);
			pst.setInt(1, classe);
			pst.setDouble(2, value);
			pst.setString(3, toAdd.getNome());
			pst.executeUpdate();
			int i = pst.executeUpdate();
			if (i==1) {return true;}
			else return false;
		} catch (SQLException e) {
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
	
public boolean deleteTariffa(Autostrada toDelete, int classe) {
		
		Connection conn=null;
		PreparedStatement pst=null;
				
		conn = MySQLDAOFactory.createConnection();
		try {
		pst = conn.prepareStatement(deleteTariffa);
		pst.setString(1, toDelete.getNome());
		pst.setInt(2, classe);
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

	public boolean updateNome(Autostrada toModify, String x) {
		Connection conn = null;
        PreparedStatement preparedStatement = null;
        try {
        	conn = MySQLDAOFactory.createConnection();
            preparedStatement = conn.prepareStatement(updateNome);
            preparedStatement.setString(1, x);
            preparedStatement.setString(2, toModify.getNome());
                    
            preparedStatement.execute();
            return true;
        } catch (SQLException e) {
            e.printStackTrace();
        } finally {
            try {
                preparedStatement.close();
            } catch (Exception sse) {
                sse.printStackTrace();
            }
            try {
                conn.close();
            } catch (Exception cse) {
                cse.printStackTrace();
            }
        }
        return false;
	}
	

	
public double getTariffa(Autostrada x, int classeVeicolo) {
		
		double valoreTariffa = 0;
		
		Connection conn=null;
		PreparedStatement pst=null;
		ResultSet rst=null;		
		try {
			conn = MySQLDAOFactory.createConnection();
			pst=conn.prepareStatement(getTariffa);
			pst.setString(1, x.getNome());
			pst.setInt(2, classeVeicolo);
			rst=pst.executeQuery();
			while(rst.next()) {valoreTariffa = rst.getDouble("valore");}
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
		return valoreTariffa;
	}

}
	