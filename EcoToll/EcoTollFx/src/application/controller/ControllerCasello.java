package application.controller;

import java.util.List;
import application.dao.DAOFactory;
import application.dao.CaselloDAO;
import application.model.Casello;
import application.model.Autostrada;

public class ControllerCasello {

	private DAOFactory mysqlfactory;
	private static CaselloDAO casellodao;
	
	public ControllerCasello() {
		mysqlfactory = DAOFactory.getDAOFactory(DAOFactory.MYSQL);
		casellodao = mysqlfactory.getCaselloDAO();
		
	}
	
	public static ControllerCasello getIstance() {
		return new ControllerCasello();
	}

	/**
	 * Metodo che restituisce una lista di Caselli nel Database
	 * @return Lista di Caselli nel Database
	 */
	public static List<Casello> getAllCas() {
		return casellodao.getListOfCasello();
	}

 	
	/**
	 * Metodo per l'eliminazione di un Casello dal Database
	 * @param Casello da eliminare dal Database
	 * @return eliminazione del Casello
	 */
	
	public boolean delete(Casello casello,Autostrada autostrada) {
		return casellodao.deleteCasello(casello,autostrada);
	}
	
	
	
	/**
	 * Metodo che utilizziamo per aggiungere caselli al Database
	 * @param nome_casello
	 * @param altezza_casello
	 * @param id_autostrada
	 * @return
	 */
	public boolean addCasello(Casello casello, Autostrada autostrada) {
		if(casellodao.addCasello(casello, autostrada)) return true;
		else return false;
	}
	
	public void updateCasello (Casello c, String s, double d) {
		casellodao.updateCasello(c, s, d);
	}

}