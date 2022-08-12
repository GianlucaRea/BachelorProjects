package application.dao;

import application.model.Amministratore;

/**
 * INTERFACCIA DAO login
 * getAmministratore -> restituisce l'amministratore passato dal database e ne permette il login;
 *
 */

public interface LoginDAO {

	public boolean getAmministratore(String username, String password);

}
