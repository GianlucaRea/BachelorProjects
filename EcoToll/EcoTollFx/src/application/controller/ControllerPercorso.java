package application.controller;

import application.dao.PercorsoDAO;
import application.dao.DAOFactory;
import application.model.Percorso;

public class ControllerPercorso {

	private DAOFactory mysqlfactory;
	private PercorsoDAO percorsodao;
	
	public ControllerPercorso() {
		mysqlfactory = DAOFactory.getDAOFactory(DAOFactory.MYSQL);
		percorsodao = mysqlfactory.getPercorsoDAO();
		
	}
	
	/**
	 * Metodo che restituisce un Percorso in base al suo codice dal Database; 
	 * @param p
	 * @return Il Percorso 
	 */
	public Percorso getIlPercorso(String p){
		return percorsodao.getPercorso(p);
	}
	
}
