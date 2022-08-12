package application.model;

/**
 * Classe Amministratore: entità che amministra e gestisce le autostrade e tutte le componenti relative ad esse.
 * @author Daniele Fossemò 
 *
 */
public class Amministratore {
	
	private String username;
	private String password;
	
	/**
	 * Metodo che costruisce amministratore
	 * @param username amministratore
	 * @param password amministratore
	 */
	public Amministratore(String username, String password) {
		this.username = username;
		this.password = password;
	}
	
	/**
	 * Metodo che costruisce Amministratore
	 * Costruttore vuoto
	 */
	public Amministratore () {}
	
	/**
	 * Metodo che restituisce l'username dell'Amministratore
	 * @return username 
	 */
	public String getUsername() {return this.username;}
	
	/**
	 * Metodo che cambia l'username dell'Amministratore
	 * @param newName
	 */
	public void setUsername(String newName) {this.username = newName;}
	
	/**
	 * Metodo che restituisce la password dell'Amministratore
	 * @return password  
	 */
	public String getPassword() {return this.password;}
	
	/**
	 * Metodo che cambia la password dell'amministratore
	 * @param newPass
	 */
	public void setPassword(String newPass) {this.username = newPass;}
}
