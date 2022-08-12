package application.dao;
 
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
 
public class MySQLDAOFactory extends DAOFactory {
 
	/** la classe driver */
    public static final String DRIVER = "com.mysql.jdbc.Driver";
    /** L'url al database */
    public static final String DBURL = "jdbc:mysql://localhost:3306/ecotolldatabase";
    /** Lo username per le operazioni sul DB  */
    public static final String USER = "root";
    /** La password per le operazioni sul DB */
    public static final String PASS = "root";
    
    /**
     * Metodo per creare una connessione sul DB MySQL
     * 
     * @return l'oggetto Connection.
     */
    public static Connection createConnection() {
        Connection conn = null;
        try {
            Class.forName(DRIVER);
            conn = DriverManager.getConnection(DBURL, USER, PASS);
        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
        	e.printStackTrace();
        }
        return conn;
    }
    
	   public AutostradaDAO getAutostradaDAO() {
		return new MySqlAutostrada();
	}
	
	   public CaselloDAO getCaselloDAO(){
		return new MySqlCasello();
	}
	   
	   public PercorsoDAO getPercorsoDAO() {
		return new MySqlPercorso();
	}
	   
	   public VeicoloDAO getVeicoloDAO() {
		return new MySqlVeicolo();
	}
	   
	   public LoginDAO getLoginDAO(){
		return new MySqlLogin();
	}
	
	
}
